<?php

declare(strict_types=1);

namespace App\Enum;

enum DocumentKeyEnum: string
{
    use EnumFromNameTrait;

    case PRIVACY_POLICY = 'privacy_policy';
    case ABOUT_SYSTEM = 'about_system';

    /** @return array<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabelKey(): string
    {
        return match ($this) {
            self::PRIVACY_POLICY => 'document.key.privacy_policy',
            self::ABOUT_SYSTEM => 'document.key.about_system',
        };
    }
}
