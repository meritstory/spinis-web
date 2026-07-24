<?php

declare(strict_types=1);

namespace App\Security;

final readonly class AdminPasswordPolicy
{
    public const int MIN_LENGTH = 12;

    public function getMinLength(): int
    {
        return self::MIN_LENGTH;
    }

    /**
     * @return list<non-empty-string>
     */
    public function validateAll(string $password): array
    {
        if ($password === '') {
            return ['password.policy.empty'];
        }

        $errors = [];

        if (mb_strlen($password) < self::MIN_LENGTH) {
            $errors[] = 'password.policy.too_short';
        }

        if (!preg_match('/\p{Lu}/u', $password)) {
            $errors[] = 'password.policy.missing_uppercase';
        }

        if (!preg_match('/\p{Ll}/u', $password)) {
            $errors[] = 'password.policy.missing_lowercase';
        }

        if (!preg_match('/\p{N}/u', $password)) {
            $errors[] = 'password.policy.missing_digit';
        }

        if (!preg_match('/[^\p{L}\p{N}]/u', $password)) {
            $errors[] = 'password.policy.missing_special';
        }

        return $errors;
    }
}
