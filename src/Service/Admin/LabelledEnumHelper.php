<?php

declare(strict_types=1);

namespace App\Service\Admin;

use Doctrine\ORM\QueryBuilder;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class LabelledEnumHelper
{
    public function __construct(
        private TranslatorInterface $translator,
    ) {
    }

    public function applyKeyLabelSort(
        QueryBuilder $queryBuilder,
        string $keyFieldPath,
        string $direction,
        string $enumClass,
    ): void {
        $caseParts = ['CASE'];
        $index = 0;

        foreach ($enumClass::cases() as $case) {
            $keyParameter = 'labelSortKey'.$index;
            $labelParameter = 'labelSortLabel'.$index;
            $caseParts[] = sprintf('WHEN %s = :%s THEN :%s', $keyFieldPath, $keyParameter, $labelParameter);
            $queryBuilder
                ->setParameter($keyParameter, (string) $case->value)
                ->setParameter($labelParameter, $this->translator->trans($case->getLabelKey()));
            ++$index;
        }

        $caseParts[] = sprintf('ELSE %s END', $keyFieldPath);
        $rootAlias = str_contains($keyFieldPath, '.') ? explode('.', $keyFieldPath, 2)[0] : 'entity';
        $queryBuilder
            ->resetDQLPart('orderBy')
            ->addSelect(implode(' ', $caseParts).' AS HIDDEN key_label_sort')
            ->addOrderBy('key_label_sort', $direction)
            ->addOrderBy(sprintf('%s.id', $rootAlias), $direction);
    }

    /** @return array<string> */
    public function findMatchingValues(string $query, string $enumClass): array
    {
        if ($query === '') {
            return [];
        }

        $needle = mb_strtolower($query);
        $values = [];

        foreach ($enumClass::cases() as $case) {
            $label = mb_strtolower($this->translator->trans($case->getLabelKey()));
            if (str_contains($label, $needle)) {
                $values[] = (string) $case->value;
            }
        }

        return $values;
    }

    /**
     * @param array<string> $usedValues
     *
     * @return array<string, string>
     */
    public function getAvailableChoices(string $enumClass, array $usedValues): array
    {
        $choices = [];

        foreach ($enumClass::cases() as $case) {
            if (!in_array($case->value, $usedValues, true)) {
                $choices[$this->translator->trans($case->getLabelKey())] = (string) $case->value;
            }
        }

        return $choices;
    }

    public function formatValue(?string $value, string $enumClass): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        $enum = $enumClass::tryFrom($value);

        return $enum !== null ? $this->translator->trans($enum->getLabelKey()) : $value;
    }
}
