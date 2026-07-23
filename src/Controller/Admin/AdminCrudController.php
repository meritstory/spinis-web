<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\RoleEnum;
use App\Repository\AdminRepository;
use App\Repository\ResetPasswordRequestRepository;
use App\Service\Admin\AdminInvitationService;
use App\Service\Admin\LabelledEnumHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @extends AbstractCrudController<Admin>
 */
#[IsGranted(RoleEnum::SYSTEM_ADMIN->value)]
class AdminCrudController extends AbstractCrudController
{
    private const string FORM_ROLE_FIELD = 'adminRole';

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly TranslatorInterface $translator,
        private readonly AdminInvitationService $invitationService,
        private readonly LabelledEnumHelper $labelledEnumHelper,
        private readonly CsrfTokenManagerInterface $csrfTokenManager,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly ResetPasswordRequestRepository $resetPasswordRequestRepository,
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
            ->setEntityLabelInSingular('admin.label.singular')
            ->setEntityLabelInPlural('menu.admins')
            ->setPageTitle(Crud::PAGE_INDEX, 'menu.admins')
            ->setPageTitle(Crud::PAGE_NEW, 'admin.page.create')
            ->setPageTitle(Crud::PAGE_EDIT, 'admin.page.edit')
            ->setPageTitle(Crud::PAGE_DETAIL, 'admin.page.detail')
            ->setSearchFields(['email', 'firstName', 'lastName'])
            ->setDefaultSort(['email' => 'ASC'])
            ->setDefaultRowAction(Action::DETAIL)
            ->setFormOptions(['attr' => ['novalidate' => 'novalidate']]);
    }

    public function configureActions(Actions $actions): Actions
    {
        $resendInvitation = Action::new('resendInvitation', 'admin.action.resend_invitation', 'fa fa-envelope')
            ->linkToUrl(fn (Admin $admin): string => $this->urlGenerator->generate(
                'admin_admin_resend_invitation',
                [
                    'entityId' => $admin->getId(),
                    'token' => $this->csrfTokenManager->getToken($this->getResendInvitationCsrfTokenId($admin)),
                ],
            ))
            ->renderAsForm()
            ->displayIf(fn (?Admin $admin): bool => $admin instanceof Admin && $this->invitationService->hasInvitation($admin));

        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, static function (Action $action): Action {
                return $action->setLabel('admin.action.create');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, static function (Action $action): Action {
                return $action->setLabel('admin.action.submit_create');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, fn (Action $action): Action => $action->askConfirmation(
                $this->translator->trans('admin.delete.confirmation'),
            ))
            ->update(Crud::PAGE_DETAIL, Action::DELETE, fn (Action $action): Action => $action->askConfirmation(
                $this->translator->trans('admin.delete.confirmation'),
            ))
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $resendInvitation)
            ->add(Crud::PAGE_DETAIL, $resendInvitation)
            ->remove(Crud::PAGE_INDEX, Action::BATCH_DELETE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER);
    }

    public function detail(AdminContext $context): KeyValueStore|Response
    {
        $this->assertAdminNotDeleted($context);

        return parent::detail($context);
    }

    public function edit(AdminContext $context): KeyValueStore|Response
    {
        $this->assertAdminNotDeleted($context);

        return parent::edit($context);
    }

    public function delete(AdminContext $context): KeyValueStore|Response
    {
        $this->assertAdminNotDeleted($context);

        $admin = $context->getEntity()->getInstance();
        $lockoutError = $admin instanceof Admin
            ? $this->getSystemAdministrationLockoutError($admin, false, false)
            : null;
        if ($admin instanceof Admin && $lockoutError !== null) {
            $this->addFlash('danger', $this->translator->trans($lockoutError));

            return $this->redirectToAdminPage(self::class, Action::DETAIL, $admin->getId());
        }

        return parent::delete($context);
    }

    #[AdminRoute(path: '/{entityId}/resend-invitation', options: ['methods' => [Request::METHOD_POST]])]
    public function resendInvitation(Request $request, #[MapEntity(id: 'entityId')] Admin $admin): RedirectResponse
    {
        if (!$this->isCsrfTokenValid($this->getResendInvitationCsrfTokenId($admin), $request->query->getString('token'))) {
            throw new AccessDeniedHttpException();
        }

        if ($admin->isDeleted()) {
            throw new NotFoundHttpException();
        }

        if (!$this->invitationService->hasInvitation($admin)) {
            $this->addFlash('danger', $this->translator->trans('admin.invitation.resend_not_allowed'));

            return $this->redirectToAdminPage(self::class, Action::INDEX);
        }

        $this->invitationService->invite($admin);

        $this->addFlash('success', $this->translator->trans('admin.invitation.resend_success'));

        return $this->redirectToAdminPage(self::class, Action::DETAIL, $admin->getId());
    }

    /** @return iterable<FieldInterface> */
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnDetail();

        if ($pageName === Crud::PAGE_NEW || $pageName === Crud::PAGE_DETAIL) {
            yield TextField::new('firstName')
                ->setLabel('admin.field.first_name')
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->setFormTypeOption('empty_data', '');

            yield TextField::new('lastName')
                ->setLabel('admin.field.last_name')
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->setFormTypeOption('empty_data', '');
        }

        yield EmailField::new('email')
            ->setLabel('admin.field.email')
            ->setRequired(true)
            ->setFormTypeOption('empty_data', '');

        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            yield BooleanField::new('emailTwoFactorEnabled')
                ->setLabel('admin.field.email_two_factor')
                ->renderAsSwitch(false);

            yield TextField::new('roleLabel')
                ->setLabel('admin.field.role')
                ->setSortable(true)
                ->formatValue(fn (?string $value, ?Admin $entity): string => $this->labelledEnumHelper->formatValue(
                    $entity?->getRoleLabel(),
                    RoleEnum::class,
                ));
        }

        if ($pageName === Crud::PAGE_DETAIL) {
            yield BooleanField::new('active')
                ->setLabel('admin.field.active')
                ->renderAsSwitch(false);
        }

        if ($pageName === Crud::PAGE_NEW) {
            yield BooleanField::new('emailTwoFactorEnabled')
                ->setLabel('admin.field.email_two_factor');

            yield ChoiceField::new(self::FORM_ROLE_FIELD)
                ->setLabel('admin.field.role')
                ->setRequired(true)
                ->setChoices($this->labelledEnumHelper->getChoicesForEnum(
                    RoleEnum::class,
                    RoleEnum::adminPanelRoleValues(),
                ))
                ->setFormTypeOption('mapped', false)
                ->setFormTypeOption('placeholder', 'admin.field.role_placeholder')
                ->setFormTypeOption('empty_data', '');
        }

        if ($pageName === Crud::PAGE_EDIT) {
            yield TextField::new('firstName')
                ->setLabel('admin.field.first_name')
                ->setRequired(true)
                ->setFormTypeOption('empty_data', '');

            yield TextField::new('lastName')
                ->setLabel('admin.field.last_name')
                ->setRequired(true)
                ->setFormTypeOption('empty_data', '');

            yield BooleanField::new('emailTwoFactorEnabled')
                ->setLabel('admin.field.email_two_factor');

            yield ChoiceField::new(self::FORM_ROLE_FIELD)
                ->setLabel('admin.field.role')
                ->setRequired(true)
                ->setChoices($this->labelledEnumHelper->getChoicesForEnum(
                    RoleEnum::class,
                    RoleEnum::adminPanelRoleValues(),
                ))
                ->setFormTypeOption('mapped', false)
                ->setFormTypeOption('placeholder', 'admin.field.role_placeholder')
                ->setFormTypeOption('empty_data', '');

            yield BooleanField::new('active')
                ->setLabel('admin.field.active')
                ->renderAsSwitch();
        }

        yield DateTimeField::new('createdAt')
            ->setLabel('admin.field.created_at')
            ->hideOnForm();
        yield DateTimeField::new('updatedAt')
            ->setLabel('admin.field.updated_at')
            ->hideOnForm();
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        foreach ($this->labelledEnumHelper->findMatchingValues(trim($searchDto->getQuery()), RoleEnum::class) as $index => $role) {
            $parameter = 'adminRoleSearch'.$index;
            $queryBuilder
                ->orWhere(sprintf('JSONB_CONTAINS(entity.roles, :%s) = true', $parameter))
                ->setParameter($parameter, json_encode($role, JSON_THROW_ON_ERROR));
        }

        $sort = $searchDto->getSort();
        if (isset($sort['roleLabel'])) {
            $this->labelledEnumHelper->applyLabelSortByJsonValue(
                $queryBuilder,
                'entity.roles',
                $sort['roleLabel'],
                RoleEnum::class,
                RoleEnum::adminPanelRoleValues(),
            );
        }

        if (isset($sort['emailTwoFactorEnabled'])) {
            $queryBuilder
                ->resetDQLPart('orderBy')
                ->addOrderBy('entity.emailTwoFactorEnabled', $sort['emailTwoFactorEnabled'])
                ->addOrderBy('entity.id', $sort['emailTwoFactorEnabled']);
        }

        return $queryBuilder;
    }

    /**
     * @return FormBuilderInterface<mixed>
     */
    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
        $this->configureRoleForm($formBuilder);

        return $formBuilder;
    }

    /**
     * @return FormBuilderInterface<mixed>
     */
    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
        $this->configureRoleForm($formBuilder);

        return $formBuilder;
    }

    public function persistEntity(EntityManagerInterface $entityManager, mixed $entityInstance): void
    {
        /** @var Admin $entityInstance */
        $this->setUnusablePassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);

        $this->invitationService->invite($entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, mixed $entityInstance): void
    {
        if (!$entityInstance instanceof Admin) {
            parent::updateEntity($entityManager, $entityInstance);

            return;
        }

        $originalData = $entityManager->getUnitOfWork()->getOriginalEntityData($entityInstance);
        $originalEmail = $originalData['email'] ?? null;
        $renewInvitation = is_string($originalEmail)
            && $originalEmail !== $entityInstance->getEmail()
            && $this->invitationService->hasInvitation($entityInstance);

        parent::updateEntity($entityManager, $entityInstance);

        if (!$renewInvitation) {
            return;
        }

        $this->invitationService->invite($entityInstance);
    }

    public function deleteEntity(EntityManagerInterface $entityManager, mixed $entityInstance): void
    {
        /** @var Admin $entityInstance */
        if ($entityInstance->getId() === null) {
            return;
        }

        $lockoutError = $this->getSystemAdministrationLockoutError($entityInstance, false, false);
        if ($lockoutError !== null) {
            $this->addFlash('danger', $this->translator->trans($lockoutError));

            return;
        }

        $this->invitationService->removeInvitationsFor($entityInstance);
        $this->resetPasswordRequestRepository->removeRequests($entityInstance);

        $entityInstance
            ->setActive(false)
            ->setEmail($entityInstance->getEmail().'#'.time());

        $entityManager->flush();
        $entityManager->remove($entityInstance);
        $entityManager->flush();
    }

    public function createEntity(string $entityFqcn): Admin
    {
        return new Admin()
            ->setActive(true)
            ->setEmailTwoFactorEnabled(true);
    }

    /**
     * @param FormBuilderInterface<mixed> $formBuilder
     */
    private function configureRoleForm(FormBuilderInterface $formBuilder): void
    {
        $formBuilder->addEventListener(FormEvents::POST_SET_DATA, static function (FormEvent $event): void {
            $admin = $event->getData();
            $form = $event->getForm();

            if (!$admin instanceof Admin || !$form->has(self::FORM_ROLE_FIELD)) {
                return;
            }

            $role = $admin->getPrimaryRole();
            if ($role !== null) {
                $form->get(self::FORM_ROLE_FIELD)->setData($role->value);
            }
        });

        $formBuilder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event): void {
            $admin = $event->getData();
            if (!$admin instanceof Admin) {
                return;
            }

            $form = $event->getForm();
            if (!$form->has(self::FORM_ROLE_FIELD)) {
                return;
            }

            $roleField = $form->get(self::FORM_ROLE_FIELD);
            $role = $roleField->getData();
            if (!is_string($role) || $role === '') {
                $roleField->addError(new FormError($this->translator->trans('admin.error.role_required')));

                return;
            }

            $roleEnum = RoleEnum::tryFromAdminRole($role);
            if ($roleEnum === null) {
                $roleField->addError(new FormError($this->translator->trans('admin.error.role_required')));

                return;
            }

            $lockoutError = $this->getSystemAdministrationLockoutError(
                $admin,
                $roleEnum === RoleEnum::SYSTEM_ADMIN,
                $admin->isActive(),
            );
            if ($lockoutError !== null) {
                $form->addError(new FormError($this->translator->trans($lockoutError)));

                return;
            }

            $admin->setRoles([$roleEnum->value]);
        });
    }

    private function setUnusablePassword(Admin $admin): void
    {
        $plainPassword = bin2hex(random_bytes(32));
        $admin->setPassword($this->passwordHasher->hashPassword($admin, $plainPassword));
    }

    private function getResendInvitationCsrfTokenId(Admin $admin): string
    {
        return 'admin-resend-invitation-'.$admin->getId();
    }

    /**
     * @param AdminContext<Admin> $context
     */
    private function assertAdminNotDeleted(AdminContext $context): void
    {
        $admin = $context->getEntity()->getInstance();
        if ($admin instanceof Admin && $admin->isDeleted()) {
            throw new NotFoundHttpException();
        }
    }

    private function getSystemAdministrationLockoutError(
        Admin $admin,
        bool $willRemainSystemAdministrator,
        bool $willRemainActive,
    ): ?string {
        if ($willRemainSystemAdministrator && $willRemainActive) {
            return null;
        }

        $authenticatedAdmin = $this->getUser();
        if (
            $authenticatedAdmin instanceof Admin
            && $authenticatedAdmin->getId() !== null
            && $authenticatedAdmin->getId() === $admin->getId()
        ) {
            return 'admin.error.own_account_lockout';
        }

        if (
            $this->adminRepository->isPersistedActiveSystemAdministrator($admin)
            && $this->adminRepository->countActiveByRole(RoleEnum::SYSTEM_ADMIN) <= 1
        ) {
            return 'admin.error.last_system_admin_lockout';
        }

        return null;
    }

    private function redirectToAdminPage(string $controllerFqcn, string $action, ?int $entityId = null): RedirectResponse
    {
        $urlGenerator = $this->container->get(AdminUrlGenerator::class)
            ->setController($controllerFqcn)
            ->setAction($action);

        if ($entityId !== null) {
            $urlGenerator->setEntityId($entityId);
        }

        return $this->redirect($urlGenerator->generateUrl());
    }
}
