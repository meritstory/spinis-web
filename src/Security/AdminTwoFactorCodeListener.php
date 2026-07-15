<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Scheb\TwoFactorBundle\Security\Http\Authenticator\Passport\Credentials\TwoFactorCodeCredentials;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

#[AsEventListener(event: CheckPassportEvent::class, priority: 512)]
final readonly class AdminTwoFactorCodeListener
{
    public function __construct(
        private AdminRepository $adminRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CheckPassportEvent $event): void
    {
        $passport = $event->getPassport();

        if (!$passport->hasBadge(TwoFactorCodeCredentials::class)) {
            return;
        }

        $credentialsBadge = $passport->getBadge(TwoFactorCodeCredentials::class);

        if (!$credentialsBadge instanceof TwoFactorCodeCredentials || $credentialsBadge->isResolved()) {
            return;
        }

        if (trim($credentialsBadge->getCode()) === '') {
            throw new CustomUserMessageAuthenticationException('login.error.empty_code');
        }

        $user = $passport->getUser();

        if (!$user instanceof Admin || $user->getId() === null) {
            return;
        }

        $admin = $this->adminRepository->find($user->getId());

        if ($admin === null) {
            return;
        }

        $this->entityManager->refresh($admin);

        if ($admin->isAuthCodeExpired()) {
            throw new CustomUserMessageAuthenticationException('login.error.expired_code');
        }
    }
}
