<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\RoleEnum;
use App\Repository\AdminRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @extends AbstractCrudController<Admin>
 */
#[IsGranted(RoleEnum::DEPARTMENT_HEAD->value)]
class SpecialistPickerCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly AdminRepository $adminRepository,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Admin::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['email', 'firstName', 'lastName'])
            ->setDefaultSort(['lastName' => 'ASC', 'firstName' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        return $this->adminRepository->applyActiveRoleConstraints(
            parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters),
            RoleEnum::SPECIALIST,
        );
    }
}
