<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Admin;
use Scheb\TwoFactorBundle\Security\Http\Authenticator\Passport\Credentials\TwoFactorCodeCredentials;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

#[AsEventListener(event: CheckPassportEvent::class, priority: 400)]
final class AdminTwoFactorExpiryListener
{
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

        $user = $passport->getUser();

        if (!$user instanceof Admin) {
            return;
        }

        if ($user->isAuthCodeExpired()) {
            throw new CustomUserMessageAuthenticationException('login.error.expired_code');
        }
    }
}
