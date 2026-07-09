<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Scheb\TwoFactorBundle\Security\Authentication\Token\TwoFactorTokenInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

#[AsEventListener(event: LoginSuccessEvent::class)]
final class AdminLoginSuccessListener
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(LoginSuccessEvent $event): void
    {
        if ($event->getFirewallName() !== 'admin') {
            return;
        }

        $user = $event->getUser();

        if (!$user instanceof Admin) {
            return;
        }

        if ($event->getAuthenticatedToken() instanceof TwoFactorTokenInterface) {
            return;
        }

        $user->setLastActiveAt(new \DateTimeImmutable());
        $user->setAuthCode(null);
        $this->entityManager->flush();
    }
}
