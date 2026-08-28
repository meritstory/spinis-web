<?php

declare(strict_types=1);

namespace App\Enum;

enum SettingKeyEnum: string
{
    use EnumFromNameTrait;

    case REQUEST_RECIPIENT_EMAIL = 'request_recipient_email';
    case VERSION = 'version';
    case HEALTH_CARE_INSTITUTION_IMPORT_FROM = 'health_care_institution_import_from';

    /** @return array<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabelKey(): string
    {
        return match ($this) {
            self::REQUEST_RECIPIENT_EMAIL => 'setting.key.request_recipient_email',
            self::VERSION => 'setting.key.version',
            self::HEALTH_CARE_INSTITUTION_IMPORT_FROM => 'setting.key.health_care_institution_import_from',
        };
    }
}
