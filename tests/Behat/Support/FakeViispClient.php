<?php

declare(strict_types=1);

namespace App\Tests\Behat\Support;

use App\Service\Viisp\ViispClientInterface;
use App\Service\Viisp\ViispIdentityData;

/**
 * Behat's Symfony test client reboots the kernel (rebuilding the container, and
 * therefore this service) between requests within a single scenario, so configured
 * state can't just live on `$this` — it has to survive across container rebuilds.
 * A small state file does that; `reset()` is called before each scenario so
 * leftover state never leaks into a scenario that never configures this fake.
 */
final class FakeViispClient implements ViispClientInterface
{
    private const string FAKE_TICKET = 'fake-ticket';
    private const string STATE_FILE = '/var/www/symfony/var/behat_viisp_fake_client_state.json';

    public function willSucceedWith(string $personalCode, string $firstName, string $lastName): void
    {
        $this->writeState([
            'personalCode' => $personalCode,
            'firstName' => $firstName,
            'lastName' => $lastName,
        ]);
    }

    public function willFail(): void
    {
        $this->writeState(['shouldFail' => true]);
    }

    public function reset(): void
    {
        if (is_file(self::STATE_FILE)) {
            unlink(self::STATE_FILE);
        }
    }

    public function getAuthenticationTicket(string $postbackUrl): string
    {
        return self::FAKE_TICKET;
    }

    public function getIdentity(string $ticket): ViispIdentityData
    {
        $state = $this->readState();

        if ($state === null || ($state['shouldFail'] ?? false) === true) {
            throw new \RuntimeException('Fake VIISP: identity exchange configured to fail.');
        }

        return new ViispIdentityData($state['personalCode'], $state['firstName'], $state['lastName']);
    }

    /**
     * @param array<string, mixed> $state
     */
    private function writeState(array $state): void
    {
        file_put_contents(self::STATE_FILE, (string) json_encode($state));
    }

    /**
     * @return array<string, mixed>|null
     */
    private function readState(): ?array
    {
        if (!is_file(self::STATE_FILE)) {
            return null;
        }

        /** @var array<string, mixed>|null $decoded */
        $decoded = json_decode((string) file_get_contents(self::STATE_FILE), true);

        return $decoded;
    }
}
