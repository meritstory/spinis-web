<?php

declare(strict_types=1);

namespace App\Tests\Behat\Support;

final class PasswordResetTokenStore
{
    private ?string $resetToken = null;

    public function set(string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }

    public function get(): ?string
    {
        return $this->resetToken;
    }

    public function clear(): void
    {
        $this->resetToken = null;
    }
}
