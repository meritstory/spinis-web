<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Setting;
use App\Enum\SettingKeyEnum;
use App\Repository\SettingRepository;
use App\Service\Admin\LabelledEnumHelper;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @extends AbstractAdminCrudController<Setting>
 */
class SettingCrudController extends AbstractAdminCrudController
{
    private const string DRAFT_RESUME_ID_ATTR = '_setting_draft_resume_id';

    public function __construct(
        private readonly SettingRepository $settingRepository,
        private readonly LabelledEnumHelper $labelledEnumHelper,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Setting::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('setting.label.singular')
            ->setEntityLabelInPlural('menu.settings')
            ->setPageTitle(Crud::PAGE_INDEX, 'menu.settings')
            ->setPageTitle(Crud::PAGE_NEW, 'setting.page.create')
            ->setPageTitle(Crud::PAGE_EDIT, 'setting.page.edit')
            ->setPageTitle(Crud::PAGE_DETAIL, 'setting.page.detail')
            ->setSearchFields(['key', 'value'])
            ->setDefaultSort(['key' => 'ASC'])
            ->setDefaultRowAction(Action::DETAIL)
            ->showEntityActionsInlined()
            ->setFormOptions(['attr' => ['novalidate' => 'novalidate']]);
    }

    public function configureActions(Actions $actions): Actions
    {
        $backToSettings = Action::new('backToSettings', 'admin.entity_not_found.back_setting')
            ->linkToCrudAction(Action::INDEX)
            ->addCssClass('btn btn-secondary action-index')
            ->displayIf(fn (): bool => !$this->hasAvailableSettingKeys());

        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, static function (Action $action): Action {
                return $action->setLabel('setting.action.create');
            })
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE, function (Action $action): Action {
                return $action
                    ->setLabel('setting.action.continue')
                    ->displayIf(fn (): bool => $this->hasAvailableSettingKeys());
            })
            ->add(Crud::PAGE_NEW, $backToSettings)
            ->disable(Action::DELETE);
    }

    public function configureFields(string $pageName): iterable
    {
        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            yield TextField::new('key')
                ->setLabel('setting.field.key')
                ->formatValue(fn (?string $value): string => $this->labelledEnumHelper->formatValue($value, SettingKeyEnum::class));
        }

        if ($pageName === Crud::PAGE_NEW) {
            if (!$this->hasAvailableSettingKeys()) {
                yield FormField::addFieldset('setting.all_created', 'fa fa-info-circle');

                return;
            }

            yield ChoiceField::new('key')
                ->setLabel('setting.field.key')
                ->setRequired(true)
                ->setChoices($this->getAvailableKeyChoices())
                ->setFormTypeOption('placeholder', 'setting.field.key_placeholder')
                ->setFormTypeOption('empty_data', '');

            return;
        }

        if ($pageName === Crud::PAGE_EDIT) {
            yield TextField::new('key')
                ->setLabel('setting.field.key')
                ->setFormTypeOption('disabled', true)
                ->setFormTypeOption('mapped', false);
        }

        $valueField = TextField::new('value')
            ->setLabel('setting.field.value')
            ->setRequired(true)
            ->setEmptyData('');

        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            $valueField
                ->setSortable(true)
                ->formatValue(function (?string $value, Setting $setting): ?string {
                    if ($value === null || !$this->isDateSetting($setting)) {
                        return $value;
                    }

                    $date = date_create_immutable($value);

                    return $date !== false ? $date->format('Y-m-d H:i') : $value;
                });
        }

        if ($pageName === Crud::PAGE_EDIT && $this->isDateSetting()) {
            $valueField
                ->setFormType(DateTimeType::class)
                ->setFormTypeOptions([
                    'input' => 'string',
                    'input_format' => DateTimeInterface::ATOM,
                    'widget' => 'single_text',
                    'empty_data' => null,
                    'required' => true,
                    'invalid_message' => 'setting.value.invalid_date',
                ]);
        }

        yield $valueField;
    }

    public function new(AdminContext $context): KeyValueStore|Response
    {
        if (!$this->hasAvailableSettingKeys() && $context->getRequest()->isMethod('POST')) {
            return $this->redirectToSettingPage(Action::INDEX);
        }

        return parent::new($context);
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $completedValueDql = $this->settingRepository->getCompletedValueDql('entity');

        $matchingKeys = $this->labelledEnumHelper->findMatchingValues(trim($searchDto->getQuery()), SettingKeyEnum::class);
        if ($matchingKeys !== []) {
            $queryBuilder
                ->orWhere(sprintf('entity.key IN (:settingLabelSearchKeys) AND %s', $completedValueDql))
                ->setParameter('settingLabelSearchKeys', $matchingKeys);
        }

        $queryBuilder
            ->andWhere($completedValueDql)
            ->setParameter('emptyValue', '');

        $customSort = $searchDto->getCustomSort();
        if (!isset($customSort['value'])) {
            $direction = $customSort['key'] ?? $searchDto->getDefaultSort()['key'] ?? 'ASC';
            $this->labelledEnumHelper->applyKeyLabelSort($queryBuilder, 'entity.key', $direction, SettingKeyEnum::class);
        }

        return $queryBuilder;
    }

    /**
     * @return FormBuilderInterface<mixed>
     */
    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);

        $formBuilder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($context): void {
            $setting = $event->getData();
            if (!$setting instanceof Setting || $setting->getKey() === '') {
                return;
            }

            $draft = $this->settingRepository->findDraftByKey($setting->getKey());
            if ($draft?->getId() === null) {
                return;
            }

            $context->getRequest()->attributes->set(self::DRAFT_RESUME_ID_ATTR, $draft->getId());
        });

        return $formBuilder;
    }

    /**
     * @return FormBuilderInterface<mixed>
     */
    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formOptions->set('validation_groups', ['Default', 'value']);

        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);

        $entity = $entityDto->getInstance();
        if ($entity instanceof Setting && $formBuilder->has('key')) {
            $formBuilder->get('key')->setData($this->labelledEnumHelper->formatValue($entity->getKey(), SettingKeyEnum::class));
        }

        return $formBuilder;
    }

    public function persistEntity(EntityManagerInterface $entityManager, object $entityInstance): void
    {
        if ($this->getContext()?->getRequest()->attributes->getInt(self::DRAFT_RESUME_ID_ATTR) > 0) {
            return;
        }

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function updateEntity(EntityManagerInterface $entityManager, object $entityInstance): void
    {
        $originalData = $entityManager->getUnitOfWork()->getOriginalEntityData($entityInstance);
        $wasDraft = trim((string) ($originalData['value'] ?? '')) === '';

        $entityManager->persist($entityInstance);
        $entityManager->flush();

        $this->addFlash('success', $wasDraft ? 'crud.flash.created' : 'crud.flash.updated');
    }

    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $draftId = $context->getRequest()->attributes->getInt(self::DRAFT_RESUME_ID_ATTR);
        if ($action === Action::NEW && $draftId > 0) {
            return $this->redirectToSettingPage(Action::EDIT, $draftId);
        }

        return parent::getRedirectResponseAfterSave($context, $action);
    }

    private function hasAvailableSettingKeys(): bool
    {
        return $this->getAvailableKeyChoices() !== [];
    }

    /** @return array<string, string> */
    private function getAvailableKeyChoices(): array
    {
        return $this->labelledEnumHelper->getAvailableChoices(
            SettingKeyEnum::class,
            $this->settingRepository->findUsedKeys(),
        );
    }

    private function isDateSetting(?Setting $setting = null): bool
    {
        $setting ??= $this->getContext()?->getEntity()?->getInstance();

        return $setting instanceof Setting
            && $setting->getKey() === SettingKeyEnum::HEALTH_CARE_INSTITUTION_IMPORT_FROM->value;
    }

    private function redirectToSettingPage(string $action, ?int $entityId = null): RedirectResponse
    {
        $urlGenerator = $this->container->get(AdminUrlGenerator::class)
            ->setController(self::class)
            ->setAction($action);

        if ($entityId !== null) {
            $urlGenerator->setEntityId($entityId);
        }

        return $this->redirect($urlGenerator->generateUrl());
    }
}
