<?php

declare(strict_types=1);

namespace App\Service\Viisp;

final readonly class ViispIdentityData
{
    public function __construct(
        public string $personalCode,
        public string $firstName,
        public string $lastName,
    ) {
    }
}
