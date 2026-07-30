<?php

declare(strict_types=1);

namespace App\Enum;

enum ComplaintStatusEnum: string
{
    use EnumFromNameTrait;

    case SUBMITTED = 'submitted';
    case IN_REVIEW = 'in_review';
    case RETURNED = 'returned';
    case AWAITING_EXPERT = 'awaiting_expert';
    case RESOLVED = 'resolved';
    case UPDATED = 'updated';

    /** @return array<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabelKey(): string
    {
        return match ($this) {
            self::SUBMITTED => 'complaint.status.submitted',
            self::IN_REVIEW => 'complaint.status.in_review',
            self::RETURNED => 'complaint.status.returned',
            self::AWAITING_EXPERT => 'complaint.status.awaiting_expert',
            self::RESOLVED => 'complaint.status.resolved',
            self::UPDATED => 'complaint.status.updated',
        };
    }

    public function getBadgeColor(): ComplaintBadgeColor
    {
        return match ($this) {
            self::SUBMITTED => ComplaintBadgeColor::Blue,
            self::IN_REVIEW, self::RETURNED, self::AWAITING_EXPERT => ComplaintBadgeColor::Green,
            self::UPDATED => ComplaintBadgeColor::Orange,
            self::RESOLVED => ComplaintBadgeColor::Gray,
        };
    }
}
