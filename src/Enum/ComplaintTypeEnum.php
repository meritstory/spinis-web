<?php

declare(strict_types=1);

namespace App\Enum;

enum ComplaintTypeEnum: string
{
    use EnumFromNameTrait;

    case PATIENT_RIGHTS = 'patient_rights';
    case DAMAGE_COMPENSATION = 'damage_compensation';

    /** @return array<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabelKey(): string
    {
        return match ($this) {
            self::PATIENT_RIGHTS => 'complaint.type.patient_rights',
            self::DAMAGE_COMPENSATION => 'complaint.type.damage_compensation',
        };
    }
}
