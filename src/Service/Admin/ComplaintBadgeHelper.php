<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Enum\ComplaintStatusEnum;
use App\Enum\ComplaintTermEnum;

final readonly class ComplaintBadgeHelper
{
    public function __construct(
        private LabelledEnumHelper $labelledEnumHelper,
    ) {
    }

    /**
     * @param class-string<ComplaintStatusEnum|ComplaintTermEnum> $enumClass
     */
    public function format(?string $value, string $enumClass): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        $enum = $enumClass::tryFrom($value);

        return $enum === null
            ? $this->escape($value)
            : $this->renderEnumBadge($enum);
    }

    public function formatTerm(?string $termValue, ?string $statusValue): string
    {
        if ($termValue === null || $termValue === '') {
            return '';
        }

        $enum = ComplaintTermEnum::tryFrom($termValue);

        if ($enum === null) {
            return $this->escape($termValue);
        }

        $badgeColor = $statusValue === ComplaintStatusEnum::RESOLVED->value
            ? 'gray'
            : $enum->getBadgeColor();

        return $this->renderEnumBadge($enum, $badgeColor);
    }

    private function renderEnumBadge(ComplaintStatusEnum|ComplaintTermEnum $enum, ?string $badgeColor = null): string
    {
        return $this->renderBadge(
            $this->labelledEnumHelper->formatValue($enum->value, $enum::class),
            $badgeColor ?? $enum->getBadgeColor(),
        );
    }

    private function renderBadge(string $label, string $badgeColor): string
    {
        return sprintf(
            '<span class="ea-complaint-badge ea-complaint-badge--%s">%s</span>',
            $this->escape($badgeColor),
            $this->escape($label),
        );
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
