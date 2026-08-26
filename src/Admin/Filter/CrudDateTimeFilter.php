<?php

declare(strict_types=1);

namespace App\Admin\Filter;

use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\ComparisonType;
use Symfony\Contracts\Translation\TranslatableInterface;

final class CrudDateTimeFilter
{
    public static function new(string $propertyName, TranslatableInterface|string|bool|null $label = null): DateTimeFilter
    {
        return DateTimeFilter::new($propertyName, $label)
            ->setFormTypeOption('comparison_type_options', [
                'choices' => [
                    'filter.label.is_not_same' => ComparisonType::NEQ,
                    'filter.label.is_after' => ComparisonType::GT,
                    'filter.label.is_after_or_same' => ComparisonType::GTE,
                    'filter.label.is_before' => ComparisonType::LT,
                    'filter.label.is_before_or_same' => ComparisonType::LTE,
                    'filter.label.is_between' => ComparisonType::BETWEEN,
                ],
                'translation_domain' => 'EasyAdminBundle',
            ]);
    }
}
