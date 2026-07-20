<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Entity\Admin;
use App\Entity\AdminInvitation;
use App\Repository\AdminInvitationRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class AdminInvitationService
{
    private const int TOKEN_BYTES = 32;
    private const int LIFETIME_SECONDS = 86400;

    public function __construct(
        private AdminInvitationRepository $invitationRepository,
        private EntityManagerInterface $entityManager,
        private AdminMailer $adminMailer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function createAndSend(Admin $admin): void
    {
        $adminId = $admin->getId();
        if ($adminId === null) {
            throw new \LogicException('Admin must be persisted before creating an invitation.');
        }

        $plainToken = bin2hex(random_bytes(self::TOKEN_BYTES));
        $invitation = new AdminInvitation(
            $admin,
            hash('sha256', $plainToken),
            new \DateTimeImmutable('+'.self::LIFETIME_SECONDS.' seconds'),
        );

        $connection = $this->entityManager->getConnection();
        $connection->beginTransaction();

        try {
            $this->entityManager->lock($admin, LockMode::PESSIMISTIC_WRITE);
            $previousInvitations = $this->invitationRepository->findBy(['admin' => $admin]);

            $this->entityManager->persist($invitation);
            $this->entityManager->flush();

            $this->adminMailer->sendAccountInvitationLink(
                $admin->getEmail(),
                $this->urlGenerator->generate(
                    'admin_invitation_link',
                    ['token' => $plainToken],
                    UrlGeneratorInterface::ABSOLUTE_URL,
                ),
            );

            if ($previousInvitations !== []) {
                foreach ($previousInvitations as $previousInvitation) {
                    $this->entityManager->remove($previousInvitation);
                }
            }
            $this->entityManager->flush();
            $connection->commit();
        } catch (TransportExceptionInterface $exception) {
            if ($connection->isTransactionActive()) {
                $connection->rollBack();
            }
            $this->entityManager->clear();

            $this->preservePendingInvitationAfterInitialFailure($adminId, $invitation);
            throw $exception;
        } catch (\Throwable $exception) {
            if ($connection->isTransactionActive()) {
                $connection->rollBack();
            }
            $this->entityManager->clear();

            throw $exception;
        }
    }

    public function hasInvitation(Admin $admin): bool
    {
        return $this->invitationRepository->findOneBy(['admin' => $admin]) !== null;
    }

    public function validateToken(string $plainToken): ?AdminInvitation
    {
        if ($plainToken === '') {
            return null;
        }

        $invitation = $this->invitationRepository->findOneBy(['tokenHash' => hash('sha256', $plainToken)]);

        return $this->isUsable($invitation) ? $invitation : null;
    }

    /**
     * @param callable(Admin): void $consume
     */
    public function consumeValidToken(string $plainToken, callable $consume): ?Admin
    {
        if ($plainToken === '') {
            return null;
        }

        return $this->entityManager->wrapInTransaction(function () use ($plainToken, $consume): ?Admin {
            $invitation = $this->invitationRepository->findOneByTokenHashForUpdate(hash('sha256', $plainToken));
            if (!$this->isUsable($invitation)) {
                return null;
            }

            $admin = $invitation->getAdmin();
            $consume($admin);
            $this->entityManager->remove($invitation);

            return $admin;
        });
    }

    public function removeInvitationsFor(Admin $admin): void
    {
        foreach ($this->invitationRepository->findBy(['admin' => $admin]) as $invitation) {
            $this->entityManager->remove($invitation);
        }
    }

    private function isUsable(?AdminInvitation $invitation): bool
    {
        if ($invitation === null || $invitation->isExpired()) {
            return false;
        }

        $admin = $invitation->getAdmin();

        return !$admin->isDeleted() && $admin->isActive();
    }

    private function preservePendingInvitationAfterInitialFailure(int $adminId, AdminInvitation $invitation): void
    {
        $admin = $this->entityManager->find(Admin::class, $adminId);
        if (
            !$admin instanceof Admin
            || $this->invitationRepository->findOneBy(['admin' => $admin]) !== null
        ) {
            return;
        }

        $this->entityManager->persist(new AdminInvitation(
            $admin,
            $invitation->getTokenHash(),
            $invitation->getExpiresAt(),
        ));
        $this->entityManager->flush();
    }
}
