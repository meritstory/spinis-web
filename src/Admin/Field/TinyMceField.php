<?php

declare(strict_types=1);

namespace App\Admin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Contracts\Translation\TranslatableInterface;

final class TinyMceField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, TranslatableInterface|string|bool|null $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('admin/field/rich_text.html.twig')
            ->setFormType(TextareaType::class)
            ->setFormTypeOption('attr', [
                'data-tinymce-editor' => 'true',
                'rows' => 8,
            ])
            ->addFormTheme('admin/form/tinymce_form_theme.html.twig')
            ->setDefaultColumns('col-md-9 col-xxl-7');
    }
}
