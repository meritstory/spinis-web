<?php

declare(strict_types=1);

namespace App\Service\Request;

use App\Enum\SettingKeyEnum;
use App\Service\Setting\SettingService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

final readonly class RequestMailer
{
    public function __construct(
        private MailerInterface $mailer,
        private SettingService $settingService,
        #[Autowire(env: 'APP_MAILER_FROM')]
        private string $mailerFrom,
        #[Autowire(env: 'APP_SHORT_NAME')]
        private string $shortName,
    ) {
    }

    public function sendNotification(string $subject, string $body): void
    {
        $recipient = $this->settingService->getRequired(SettingKeyEnum::REQUEST_RECIPIENT_EMAIL);

        $emailMessage = new TemplatedEmail()
            ->from(new Address($this->mailerFrom, $this->shortName))
            ->to($recipient)
            ->subject($subject)
            ->htmlTemplate('emails/request_notification.html.twig')
            ->context([
                'body' => $body,
            ])
        ;

        $this->mailer->send($emailMessage);
    }

    public function getRecipientEmail(): string
    {
        return $this->settingService->getRequired(SettingKeyEnum::REQUEST_RECIPIENT_EMAIL);
    }
}
