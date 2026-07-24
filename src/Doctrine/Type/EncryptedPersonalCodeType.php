<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Deterministic AES-256-GCM encryption for the `personal_code` column.
 *
 * Doctrine instantiates custom types itself with no constructor, so the
 * encryption key is read directly from the environment rather than
 * injected via DI — the standard workaround for this Doctrine limitation.
 *
 * The nonce is derived deterministically from the plaintext (HMAC-SHA256,
 * truncated to 12 bytes) using a key kept separate from the encryption
 * key (both derived from one root secret via HKDF), so the same
 * plaintext always produces the same ciphertext. That's what lets
 * `WHERE personal_code = :x` and the DB unique constraint keep working
 * unmodified elsewhere in the app. This intentionally trades away
 * semantic security (ciphertext reveals which rows share a plaintext)
 * for exact-match searchability — accepted specifically because
 * `personal_code` already has a DB-level unique constraint, so there
 * are never any repeats to reveal in the first place.
 */
final class EncryptedPersonalCodeType extends Type
{
    public const string NAME = 'encrypted_personal_code';

    private const string CIPHER_ALGO = 'aes-256-gcm';
    private const int NONCE_LENGTH = 12;
    private const int TAG_LENGTH = 16;

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        [$nonceKey, $cipherKey] = $this->deriveKeys();
        $plaintext = (string) $value;

        $nonce = substr(hash_hmac('sha256', $plaintext, $nonceKey, true), 0, self::NONCE_LENGTH);

        $ciphertext = openssl_encrypt($plaintext, self::CIPHER_ALGO, $cipherKey, OPENSSL_RAW_DATA, $nonce, $tag);
        if ($ciphertext === false) {
            throw new \RuntimeException('Failed to encrypt personal code: '.openssl_error_string());
        }

        return base64_encode($nonce.$tag.$ciphertext);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        $raw = base64_decode((string) $value, true);
        if ($raw === false || strlen($raw) <= self::NONCE_LENGTH + self::TAG_LENGTH) {
            throw new \RuntimeException('Failed to decode encrypted personal code.');
        }

        $nonce = substr($raw, 0, self::NONCE_LENGTH);
        $tag = substr($raw, self::NONCE_LENGTH, self::TAG_LENGTH);
        $ciphertext = substr($raw, self::NONCE_LENGTH + self::TAG_LENGTH);

        [, $cipherKey] = $this->deriveKeys();

        $plaintext = openssl_decrypt($ciphertext, self::CIPHER_ALGO, $cipherKey, OPENSSL_RAW_DATA, $nonce, $tag);
        if ($plaintext === false) {
            throw new \RuntimeException('Failed to decrypt personal code: data may be corrupted or the encryption key is wrong.');
        }

        return $plaintext;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL(['length' => 255] + $column);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return array{0: string, 1: string} [$nonceKey, $cipherKey]
     */
    private function deriveKeys(): array
    {
        $rootKey = base64_decode((string) ($_ENV['COMPLAINANT_PERSONAL_CODE_ENCRYPTION_KEY'] ?? ''), true);

        if ($rootKey === false || $rootKey === '') {
            throw new \RuntimeException('COMPLAINANT_PERSONAL_CODE_ENCRYPTION_KEY is not configured.');
        }

        $nonceKey = hash_hkdf('sha256', $rootKey, 32, 'personal_code.nonce');
        $cipherKey = hash_hkdf('sha256', $rootKey, 32, 'personal_code.cipher');

        return [$nonceKey, $cipherKey];
    }
}