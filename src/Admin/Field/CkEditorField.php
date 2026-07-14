<?php

declare(strict_types=1);

namespace App\Admin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Contracts\Translation\TranslatableInterface;

final class CkEditorField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, TranslatableInterface|string|bool|null $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('admin/field/ckeditor.html.twig')
            ->setFormType(CKEditorType::class)
            ->setFormTypeOption('config_name', 'standard')
            ->addCssClass('field-text_editor')
            ->addCssFiles(Asset::fromEasyAdminAssetPackage('field-text-editor.css')->onlyOnForms())
            ->setDefaultColumns('col-md-9 col-xxl-7')
            ->addFormTheme('admin/form/ckeditor_form_theme.html.twig');
    }
}
