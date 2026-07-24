<?php

declare(strict_types=1);

namespace App\Tests\Behat\Support;

use App\Service\Viisp\ViispClientInterface;
use App\Service\Viisp\ViispIdentityData;

/**
 * Behat's Symfony test client reboots the kernel (rebuilding the container, and
 * therefore this service) between requests within a single scenario, so configured
 * state can't just live on `$this` — it has to survive across container rebuilds.
 * A static property does that, since it's process-level rather than
 * container-level; `reset()` is called before each scenario so leftover state
 * never leaks into a scenario that never configures this fake.
 */
final class FakeViispClient implements ViispClientInterface
{
    private const string FAKE_TICKET = 'fake-ticket';

    /** @var array<string, mixed>|null */
    private static ?array $state = null;

    public function willSucceedWith(string $personalCode, string $firstName, string $lastName): void
    {
        self::$state = [
            'personalCode' => $personalCode,
            'firstName' => $firstName,
            'lastName' => $lastName,
        ];
    }

    public function willFail(): void
    {
        self::$state = ['shouldFail' => true];
    }

    public function reset(): void
    {
        self::$state = null;
    }

    public function getAuthenticationTicket(string $postbackUrl): string
    {
        return self::FAKE_TICKET;
    }

    public function getIdentity(string $ticket): ViispIdentityData
    {
        $state = self::$state;

        if ($state === null || ($state['shouldFail'] ?? false) === true) {
            throw new \RuntimeException('Fake VIISP: identity exchange configured to fail.');
        }

        return new ViispIdentityData($state['personalCode'], $state['firstName'], $state['lastName']);
    }
}
