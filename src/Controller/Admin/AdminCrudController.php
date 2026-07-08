<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\RoleEnum;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @extends AbstractCrudController<Admin>
 */
class AdminCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Admin::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('admin.label.singular')
            ->setEntityLabelInPlural('admin.label.plural')
            ->setPageTitle('index', 'admin.label.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('username')->setLabel('admin.field.username');
        yield ChoiceField::new('roles')
            ->setLabel('admin.field.roles')
            ->setChoices([
                $this->translator->trans('admin.role.admin') => RoleEnum::ADMIN->value,
            ])
            ->allowMultipleChoices()
            ->renderExpanded();
        yield TextField::new('password')
            ->setLabel('admin.field.password')
            ->setFormType(PasswordType::class)
            ->onlyOnForms()
            ->setRequired(Crud::PAGE_NEW === $pageName)
            ->setFormTypeOption('empty_data', '');
    }

    public function persistEntity(EntityManagerInterface $entityManager, mixed $entityInstance): void
    {
        /** @var Admin $entityInstance */
        $this->encodePassword($entityInstance);

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, mixed $entityInstance): void
    {
        /** @var Admin $entityInstance */
        $plainPassword = $entityInstance->getPassword();

        if ($plainPassword === null || $plainPassword === '') {
            $originalData = $entityManager->getUnitOfWork()->getOriginalEntityData($entityInstance);
            $originalPassword = $originalData['password'] ?? null;

            if (is_string($originalPassword) && $originalPassword !== '') {
                $entityInstance->setPassword($originalPassword);
            }
        } else {
            $this->encodePassword($entityInstance);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function encodePassword(Admin $admin): void
    {
        $plainPassword = $admin->getPassword();

        if ($plainPassword === null || $plainPassword === '') {
            return;
        }

        $admin->setPassword($this->passwordHasher->hashPassword($admin, $plainPassword));
    }
}
