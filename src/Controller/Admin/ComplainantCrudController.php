<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Complainant;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 * @extends AbstractCrudController<Complainant>
 */
class ComplainantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Complainant::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('complainant.label.singular')
            ->setEntityLabelInPlural('menu.complainants')
            ->setPageTitle(Crud::PAGE_INDEX, 'menu.complainants')
            ->setPageTitle(Crud::PAGE_DETAIL, 'complainant.page.detail')
            ->setSearchFields(['firstName', 'lastName'])
            ->setDefaultSort(['lastName' => 'ASC'])
            ->setDefaultRowAction(Action::DETAIL);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW, Action::EDIT, Action::DELETE, Action::BATCH_DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, static function (Action $action): Action {
                return $action->setLabel('complainant.action.view');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm()->hideOnIndex();
        yield TextField::new('firstName')
            ->setLabel('complainant.field.first_name');
        yield TextField::new('lastName')
            ->setLabel('complainant.field.last_name');
        yield BooleanField::new('legalEntity')
            ->setLabel('complainant.field.legal_entity')
            ->hideOnIndex();
        yield TextField::new('personalCode')
            ->setLabel('complainant.field.personal_code')
            ->hideOnIndex();
        yield TextField::new('companyCode')
            ->setLabel('complainant.field.company_code')
            ->hideOnIndex();
        yield TextField::new('companyName')
            ->setLabel('complainant.field.company_name')
            ->hideOnIndex();
        yield EmailField::new('email')
            ->setLabel('complainant.field.email')
            ->hideOnIndex();
        yield TelephoneField::new('phone')
            ->setLabel('complainant.field.phone')
            ->hideOnIndex();
        yield TextField::new('address')
            ->setLabel('complainant.field.address')
            ->hideOnIndex();
        yield DateTimeField::new('createdAt')
            ->setLabel('complainant.field.created_at')
            ->hideOnForm();
        yield DateTimeField::new('updatedAt')
            ->setLabel('complainant.field.updated_at')
            ->hideOnForm();
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $sort = $searchDto->getSort();
        $fieldsToSort = array_values(array_intersect(array_keys($sort), ['lastName', 'firstName']));

        if ($fieldsToSort === []) {
            $fieldsToSort = ['lastName'];
        }

        $queryBuilder->resetDQLPart('orderBy');

        foreach ($fieldsToSort as $field) {
            $direction = strtoupper((string) ($sort[$field] ?? 'ASC')) === 'DESC' ? 'DESC' : 'ASC';
            $alias = $field.'_lt_sort';

            $queryBuilder
                ->addSelect(sprintf('LT_ALPHABET_LOWER(entity.%s) AS HIDDEN %s', $field, $alias))
                ->addOrderBy($alias, $direction);
        }

        $queryBuilder->addOrderBy('entity.id', 'ASC');

        return $queryBuilder;
    }
}
