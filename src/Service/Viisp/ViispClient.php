<?php

declare(strict_types=1);

namespace App\Service\Viisp;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Target;

readonly class ViispClient implements ViispClientInterface
{
    public function __construct(
        private ViispTicket $viispTicket,
        private ViispIdentity $viispIdentity,
        #[Target('viisp')]
        private LoggerInterface $logger,
        private string $privateKey,
        private string $privateKeyNew,
    ) {
    }

    public function getAuthenticationTicket(string $postbackUrl): string
    {
        try {
            return $this->viispTicket->getAuthenticationTicket($postbackUrl, $this->privateKey);
        } catch (\Throwable $exception) {
            if ($this->privateKeyNew === '') {
                throw $exception;
            }

            $authenticationTicket = $this->viispTicket->getAuthenticationTicket($postbackUrl, $this->privateKeyNew);
            $this->logger->warning('VIISP: new private key used for getAuthenticationTicket successfully. Please replace the primary key.');

            return $authenticationTicket;
        }
    }

    public function getIdentity(string $ticket): ViispIdentityData
    {
        try {
            return $this->viispIdentity->getIdentity($ticket, $this->privateKey);
        } catch (\Throwable $exception) {
            if ($this->privateKeyNew === '') {
                throw $exception;
            }

            $identity = $this->viispIdentity->getIdentity($ticket, $this->privateKeyNew);
            $this->logger->warning('VIISP: new private key used for getIdentity successfully. Please replace the primary key.');

            return $identity;
        }
    }
}
