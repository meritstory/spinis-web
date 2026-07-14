<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Admin\Field\CkEditorField;
use App\Entity\Faq;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 * @extends AbstractCrudController<Faq>
 */
class FaqCrudController extends AbstractCrudController
{
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
            ->setDefaultRowAction(Action::DETAIL);
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

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('question')
            ->setLabel('faq.field.question')
            ->setRequired(true)
            ->setFormTypeOption('empty_data', '');
        yield CkEditorField::new('answer')
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
