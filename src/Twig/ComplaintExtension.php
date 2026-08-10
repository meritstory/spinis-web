<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Complaint;
use App\Enum\ComplaintTypeEnum;
use App\Service\Admin\ComplaintBadgeHelper;
use App\Service\Admin\LabelledEnumHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ComplaintExtension extends AbstractExtension
{
    public function __construct(
        private readonly ComplaintBadgeHelper $complaintBadgeHelper,
        private readonly LabelledEnumHelper $labelledEnumHelper,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('complaint_term_badge', $this->formatTermBadge(...), ['is_safe' => ['html']]),
            new TwigFunction('complaint_type_label', $this->formatTypeLabel(...)),
        ];
    }

    private function formatTermBadge(Complaint $complaint): string
    {
        return $this->complaintBadgeHelper->formatTerm(
            $complaint->getTermStatus(),
            $complaint->getStatus(),
        );
    }

    private function formatTypeLabel(Complaint $complaint): string
    {
        return $this->labelledEnumHelper->formatValue($complaint->getType(), ComplaintTypeEnum::class);
    }
}
