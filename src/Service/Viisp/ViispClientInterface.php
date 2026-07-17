<?php

declare(strict_types=1);

namespace App\Service\Viisp;

interface ViispClientInterface
{
    public function getAuthenticationTicket(string $postbackUrl): string;

    public function getIdentity(string $ticket): ViispIdentityData;
}
