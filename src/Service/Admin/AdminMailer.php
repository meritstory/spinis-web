<?php

declare(strict_types=1);

namespace App\Service\Admin;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class AdminMailer
{
    public function __construct(
        private MailerInterface $mailer,
        private TranslatorInterface $translator,
        #[Autowire(env: 'APP_MAILER_FROM')]
        private string $mailerFrom,
        #[Autowire(env: 'APP_SHORT_NAME')]
        private string $shortName,
    ) {
    }

    public function sendAuthenticationCode(string $email, string $code): void
    {
        $emailMessage = new TemplatedEmail()
            ->from(new Address($this->mailerFrom, $this->shortName))
            ->to($email)
            ->subject($this->translator->trans('email.auth_code.subject'))
            ->htmlTemplate('emails/authentication_code.html.twig')
            ->context([
                'code' => $code,
            ])
        ;

        $this->mailer->send($emailMessage);
    }

    public function sendPasswordResetLink(string $email, string $resetUrl): void
    {
        $emailMessage = new TemplatedEmail()
            ->from(new Address($this->mailerFrom, $this->shortName))
            ->to($email)
            ->subject($this->translator->trans('email.password_reset.subject'))
            ->htmlTemplate('emails/password_reset.html.twig')
            ->context([
                'resetUrl' => $resetUrl,
            ])
        ;

        $this->mailer->send($emailMessage);
    }

    public function sendAccountInvitationLink(string $email, string $invitationUrl): void
    {
        $emailMessage = new TemplatedEmail()
            ->from(new Address($this->mailerFrom, $this->shortName))
            ->to($email)
            ->subject($this->translator->trans('email.account_invitation.subject'))
            ->htmlTemplate('emails/account_invitation.html.twig')
            ->context([
                'invitationUrl' => $invitationUrl,
            ])
        ;

        $this->mailer->send($emailMessage);
    }
}
