<?php

declare(strict_types=1);

namespace App\Service\Admin;

use BackedEnum;
use App\Enum\ComplaintBadgeColor;
use App\Enum\ComplaintStatusEnum;
use App\Enum\ComplaintTermEnum;
use Twig\Environment;

final readonly class ComplaintBadgeHelper
{
    public function __construct(
        private LabelledEnumHelper $labelledEnumHelper,
        private Environment $twig,
    ) {
    }

    /**
     * @param class-string<ComplaintStatusEnum|ComplaintTermEnum> $enumClass
     */
    public function format(BackedEnum|string|null $value, string $enumClass): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        $enumValue = $value instanceof BackedEnum ? $value->value : $value;
        $enum = $enumClass::tryFrom($enumValue);

        return $enum === null
            ? $this->escape((string) $enumValue)
            : $this->renderEnumBadge($enum);
    }

    public function formatTerm(
        ComplaintTermEnum|string|null $termValue,
        ComplaintStatusEnum|string|null $statusValue,
    ): string
    {
        if ($termValue === null || $termValue === '') {
            return '';
        }

        $term = $termValue instanceof ComplaintTermEnum ? $termValue : ComplaintTermEnum::tryFrom($termValue);

        if ($term === null) {
            return $this->escape($termValue);
        }

        $status = $statusValue instanceof ComplaintStatusEnum
            ? $statusValue
            : ($statusValue !== null ? ComplaintStatusEnum::tryFrom($statusValue) : null);
        $badgeColor = $status === ComplaintStatusEnum::RESOLVED
            ? ComplaintBadgeColor::Gray
            : $term->getBadgeColor();

        return $this->renderEnumBadge($term, $badgeColor);
    }

    private function renderEnumBadge(ComplaintStatusEnum|ComplaintTermEnum $enum, ?ComplaintBadgeColor $badgeColor = null): string
    {
        return $this->renderBadge(
            $this->labelledEnumHelper->formatValue($enum->value, $enum::class),
            $badgeColor ?? $enum->getBadgeColor(),
        );
    }

    private function renderBadge(string $label, ComplaintBadgeColor $badgeColor): string
    {
        return $this->twig->render('admin/field/complaint_badge.html.twig', [
            'label' => $label,
            'color' => $badgeColor->value,
        ]);
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
