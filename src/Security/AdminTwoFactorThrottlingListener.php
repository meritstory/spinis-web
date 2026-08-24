<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Event\TwoFactorAuthenticationEvent;
use Scheb\TwoFactorBundle\Security\TwoFactor\Event\TwoFactorAuthenticationEvents;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\RateLimiter\RateLimiterFactoryInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

#[AsEventListener(event: TwoFactorAuthenticationEvents::ATTEMPT, method: 'onAttempt')]
#[AsEventListener(event: TwoFactorAuthenticationEvents::SUCCESS, method: 'onSuccess')]
final readonly class AdminTwoFactorThrottlingListener
{
    public function __construct(
        private RateLimiterFactoryInterface $twoFactorCheckLimiter,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function onAttempt(TwoFactorAuthenticationEvent $event): void
    {
        $limit = $this->twoFactorCheckLimiter->create($this->getKey($event))->consume();

        if ($limit->isAccepted()) {
            return;
        }

        $this->invalidateAuthCode($event);

        throw new CustomUserMessageAuthenticationException('login.error.too_many_code_attempts', [
            '%minutes%' => max(1, (int) ceil(($limit->getRetryAfter()->getTimestamp() - time()) / 60)),
        ]);
    }

    public function onSuccess(TwoFactorAuthenticationEvent $event): void
    {
        $this->twoFactorCheckLimiter->create($this->getKey($event))->reset();
    }

    private function invalidateAuthCode(TwoFactorAuthenticationEvent $event): void
    {
        $user = $event->getToken()->getUser();

        if (!$user instanceof Admin || $user->getAuthCode() === null) {
            return;
        }

        $user->setAuthCode(null);
        $this->entityManager->flush();
    }

    private function getKey(TwoFactorAuthenticationEvent $event): string
    {
        return sprintf('2fa_check:%s', $event->getToken()->getUserIdentifier());
    }
}
