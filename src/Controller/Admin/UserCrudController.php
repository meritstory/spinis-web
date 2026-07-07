<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\RoleEnum;
use App\Entity\User;
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
 * @extends AbstractCrudController<User>
 */
class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('user.label.singular')
            ->setEntityLabelInPlural('user.label.plural')
            ->setPageTitle('index', 'user.label.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('username')->setLabel('user.field.username');
        yield ChoiceField::new('roles')
            ->setLabel('user.field.roles')
            ->setChoices([
                $this->translator->trans('user.role.admin') => RoleEnum::ADMIN->value,
            ])
            ->allowMultipleChoices()
            ->renderExpanded();
        yield TextField::new('password')
            ->setLabel('user.field.password')
            ->setFormType(PasswordType::class)
            ->onlyOnForms()
            ->setRequired(Crud::PAGE_NEW === $pageName);
    }

    public function persistEntity(EntityManagerInterface $entityManager, mixed $entityInstance): void
    {
        /** @var User $entityInstance */
        $this->encodePassword($entityInstance);

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, mixed $entityInstance): void
    {
        /** @var User $entityInstance */
        $plainPassword = $entityInstance->getPassword();

        if (null === $plainPassword || '' === $plainPassword) {
            $existingUser = $entityManager->getRepository(User::class)->find($entityInstance->getId());

            if ($existingUser instanceof User) {
                $entityInstance->setPassword($existingUser->getPassword());
            }
        } else {
            $this->encodePassword($entityInstance);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function encodePassword(User $user): void
    {
        $plainPassword = $user->getPassword();

        if (null === $plainPassword || '' === $plainPassword) {
            return;
        }

        $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));
    }
}
