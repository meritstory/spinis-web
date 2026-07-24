<?php

declare(strict_types=1);

namespace App\Service\Viisp;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class ViispClient implements ViispClientInterface
{
    public function __construct(
        private ViispTicket $viispTicket,
        private ViispIdentity $viispIdentity,
        #[Autowire(env: 'resolve:VIISP_PRIVATE_KEY')]
        private string $privateKey,
    ) {
    }

    public function getAuthenticationTicket(string $postbackUrl): string
    {
        return $this->viispTicket->getAuthenticationTicket($postbackUrl, $this->privateKey);
    }

    public function getIdentity(string $ticket): ViispIdentityData
    {
        return $this->viispIdentity->getIdentity($ticket, $this->privateKey);
    }
}
