<?php

declare(strict_types=1);

namespace App\Admin\Filter;

use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\DateTimeFilterType;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\ComparisonType;
use Symfony\Contracts\Translation\TranslatableInterface;

final class CrudDateTimeFilter implements FilterInterface
{
    use FilterTrait;

    /**
     * @param TranslatableInterface|string|false|null $label
     */
    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setFilterFqcn(self::class)
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(DateTimeFilterType::class)
            ->setFormTypeOption('translation_domain', 'EasyAdminBundle')
            ->setFormTypeOption('comparison_type_options', [
                'choices' => [
                    'filter.label.is_after' => ComparisonType::GT,
                    'filter.label.is_after_or_same' => ComparisonType::GTE,
                    'filter.label.is_before' => ComparisonType::LT,
                    'filter.label.is_before_or_same' => ComparisonType::LTE,
                    'filter.label.is_between' => ComparisonType::BETWEEN,
                ],
                'translation_domain' => 'EasyAdminBundle',
            ]);
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
        $alias = $filterDataDto->getEntityAlias();
        $property = $filterDataDto->getProperty();
        $comparison = $filterDataDto->getComparison();
        $parameterName = $filterDataDto->getParameterName();
        $parameter2Name = $filterDataDto->getParameter2Name();
        $value = $filterDataDto->getValue();
        $value2 = $filterDataDto->getValue2();

        if (null === $value) {
            $queryBuilder->andWhere(sprintf('%s.%s %s', $alias, $property, $comparison));

            return;
        }

        if (!$value instanceof \DateTimeInterface) {
            return;
        }

        $field = sprintf('%s.%s', $alias, $property);
        $minuteStart = $this->truncateToMinute($value);
        $nextMinute = $minuteStart->modify('+1 minute');

        switch ($comparison) {
            case ComparisonType::GT:
                $queryBuilder->andWhere(sprintf('%s >= :%s', $field, $parameterName))
                    ->setParameter($parameterName, $nextMinute);
                break;
            case ComparisonType::GTE:
                $queryBuilder->andWhere(sprintf('%s >= :%s', $field, $parameterName))
                    ->setParameter($parameterName, $minuteStart);
                break;
            case ComparisonType::LT:
                $queryBuilder->andWhere(sprintf('%s < :%s', $field, $parameterName))
                    ->setParameter($parameterName, $minuteStart);
                break;
            case ComparisonType::LTE:
                $queryBuilder->andWhere(sprintf('%s < :%s', $field, $parameterName))
                    ->setParameter($parameterName, $nextMinute);
                break;
            case ComparisonType::BETWEEN:
                if (!$value2 instanceof \DateTimeInterface) {
                    return;
                }

                $rangeStart = $minuteStart;
                $rangeEndMinute = $this->truncateToMinute($value2);

                if ($rangeStart > $rangeEndMinute) {
                    [$rangeStart, $rangeEndMinute] = [$rangeEndMinute, $rangeStart];
                }

                $rangeEndExclusive = $rangeEndMinute->modify('+1 minute');

                $queryBuilder->andWhere(sprintf('%s >= :%s AND %s < :%s', $field, $parameterName, $field, $parameter2Name))
                    ->setParameter($parameterName, $rangeStart)
                    ->setParameter($parameter2Name, $rangeEndExclusive);
                break;
        }
    }

    private function truncateToMinute(\DateTimeInterface $dateTime): \DateTimeImmutable
    {
        $normalized = \DateTimeImmutable::createFromInterface($dateTime);

        return $normalized->setTime(
            (int) $normalized->format('H'),
            (int) $normalized->format('i'),
        );
    }
}
