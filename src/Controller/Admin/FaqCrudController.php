<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Admin\Field\TinyMceField;
use App\Admin\Filter\CrudDateTimeFilter;
use App\Entity\Faq;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 * @extends AbstractAdminCrudController<Faq>
 */
class FaqCrudController extends AbstractAdminCrudController
{
    protected function getFlashEntityKey(): ?string
    {
        return 'faq';
    }

    public static function getEntityFqcn(): string
    {
        return Faq::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('faq.label.singular')
            ->setEntityLabelInPlural('menu.faq')
            ->setPageTitle(Crud::PAGE_INDEX, 'menu.faq')
            ->setPageTitle(Crud::PAGE_NEW, 'faq.page.create')
            ->setPageTitle(Crud::PAGE_EDIT, 'faq.page.edit')
            ->setPageTitle(Crud::PAGE_DETAIL, 'faq.page.detail')
            ->setSearchFields(['question', 'answer'])
            ->setDefaultSort(['position' => 'ASC'])
            ->setDefaultRowAction(Action::DETAIL)
            ->showEntityActionsInlined()
            ->setFormOptions(['attr' => ['novalidate' => 'novalidate']]);
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets->addAssetMapperEntry(
            Asset::new('admin/tinymce-field')->onlyOnForms()
        );
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, static function (Action $action): Action {
                return $action->setLabel('faq.action.create');
            })
            ->add(Crud::PAGE_EDIT, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(CrudDateTimeFilter::new('createdAt', 'faq.field.created_at'))
            ->add(CrudDateTimeFilter::new('updatedAt', 'faq.field.updated_at'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('question')
            ->setLabel('faq.field.question')
            ->setRequired(true)
            ->setFormTypeOption('empty_data', '');
        yield TinyMceField::new('answer')
            ->setLabel('faq.field.answer')
            ->hideOnIndex()
            ->setRequired(true)
            ->setFormTypeOption('empty_data', '');
        yield IntegerField::new('position')
            ->setLabel('faq.field.position')
            ->setRequired(true)
            ->setHtmlAttribute('min', 1)
            ->setHtmlAttribute('step', 1);
        yield DateTimeField::new('createdAt')
            ->setLabel('faq.field.created_at')
            ->hideOnForm();
        yield DateTimeField::new('updatedAt')
            ->setLabel('faq.field.updated_at')
            ->hideOnForm();
    }
}
