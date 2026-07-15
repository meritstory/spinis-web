<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Link;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 * @extends AbstractCrudController<Link>
 */
class LinkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Link::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('link.label.singular')
            ->setEntityLabelInPlural('menu.links')
            ->setPageTitle(Crud::PAGE_INDEX, 'menu.links')
            ->setPageTitle(Crud::PAGE_NEW, 'link.page.new')
            ->setPageTitle(Crud::PAGE_EDIT, 'link.page.edit')
            ->setSearchFields(['title', 'key'])
            ->setDefaultRowAction(Action::DETAIL);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, static function (Action $action): Action {
                return $action->addCssClass('d-none');
            })
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->update(Crud::PAGE_INDEX, Action::NEW, static function (Action $action): Action {
                return $action->setLabel('link.action.create');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title')
            ->setLabel('link.field.title')
            ->setRequired(true)
            ->setEmptyData('');
        yield TextField::new('key')
            ->setLabel('link.field.key')
            ->setRequired(true)
            ->setEmptyData('');
        yield TextField::new('url')
            ->setLabel('link.field.url')
            ->setRequired(true)
            ->setEmptyData('');
    }
}
