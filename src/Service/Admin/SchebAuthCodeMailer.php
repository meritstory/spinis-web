<?php

declare(strict_types=1);

namespace App\Service\Admin;

use Scheb\TwoFactorBundle\Mailer\AuthCodeMailerInterface;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;

final readonly class SchebAuthCodeMailer implements AuthCodeMailerInterface
{
    public function __construct(
        private AdminMailer $adminMailer,
    ) {
    }

    public function sendAuthCode(TwoFactorInterface $user): void
    {
        $code = $user->getEmailAuthCode();

        if ($code === null || $code === '') {
            return;
        }

        $this->adminMailer->sendAuthenticationCode($user->getEmailAuthRecipient(), $code);
    }
}
