<?php

declare(strict_types=1);

namespace App\Enum;

enum ComplaintTermEnum: string
{
    use EnumFromNameTrait;

    case ON_TIME = 'on_time';
    case OVERDUE = 'overdue';
    case APPROACHING = 'approaching';

    /** @return array<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabelKey(): string
    {
        return match ($this) {
            self::ON_TIME => 'complaint.term.on_time',
            self::OVERDUE => 'complaint.term.overdue',
            self::APPROACHING => 'complaint.term.approaching',
        };
    }

    public function getBadgeColor(): ComplaintBadgeColor
    {
        return match ($this) {
            self::ON_TIME => ComplaintBadgeColor::Blue,
            self::APPROACHING => ComplaintBadgeColor::Orange,
            self::OVERDUE => ComplaintBadgeColor::Red,
        };
    }
}
