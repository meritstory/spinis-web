<?php

declare(strict_types=1);

namespace App\Service\Admin;

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
            ? ComplaintBadgeColor::Gray
            : $enum->getBadgeColor();

        return $this->renderEnumBadge($enum, $badgeColor);
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
