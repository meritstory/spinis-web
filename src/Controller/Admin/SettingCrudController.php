<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Setting;
use App\Enum\SettingKeyEnum;
use App\Repository\SettingRepository;
use App\Service\Admin\LabelledEnumHelper;
use DateTimeInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @extends AbstractCrudController<Setting>
 */
class SettingCrudController extends AbstractCrudController
{
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
            ->setSearchFields(['value'])
            ->setDefaultSort(['key' => 'ASC'])
            ->setDefaultRowAction(Action::DETAIL)
            ->setFormOptions(['attr' => ['novalidate' => 'novalidate']]);
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, static function (Action $action): Action {
                return $action->setLabel('setting.action.create');
            })
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE, static function (Action $action): Action {
                return $action->setLabel('setting.action.continue');
            })
            ->disable(Action::DELETE);

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();

        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            yield TextField::new('key')
                ->setLabel('setting.field.key')
                ->formatValue(fn (?string $value): string => $this->labelledEnumHelper->formatValue($value, SettingKeyEnum::class));
        }

        if ($pageName === Crud::PAGE_NEW) {
            $availableChoices = $this->getAvailableKeyChoices();

            $keyField = ChoiceField::new('key')
                ->setLabel('setting.field.key')
                ->setRequired(true)
                ->setChoices($availableChoices)
                ->setFormTypeOption('placeholder', 'setting.field.key_placeholder')
                ->setFormTypeOption('empty_data', '');

            if ($availableChoices === []) {
                $keyField = $keyField->setHelp('setting.all_created');
            }

            yield $keyField;
        }

        if ($pageName === Crud::PAGE_EDIT) {
            yield TextField::new('key')
                ->setLabel('setting.field.key')
                ->setFormTypeOption('disabled', true)
                ->setFormTypeOption('mapped', false);
        }

        if ($pageName === Crud::PAGE_NEW) {
            return;
        }

        $valueField = TextField::new('value')
            ->setLabel('setting.field.value')
            ->setRequired(true)
            ->setEmptyData('');

        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            $valueField->formatValue(function (?string $value, Setting $setting): ?string {
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
                    'invalid_message' => 'setting.value.invalid_date',
                ]);
        }

        yield $valueField;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $sort = $searchDto->getSort();
        if (isset($sort['key'])) {
            $this->labelledEnumHelper->applyKeyLabelSort($queryBuilder, 'entity.key', $sort['key'], SettingKeyEnum::class);
        }

        $matchingKeys = $this->labelledEnumHelper->findMatchingValues(trim($searchDto->getQuery()), SettingKeyEnum::class);
        if ($matchingKeys !== []) {
            $queryBuilder
                ->orWhere('entity.key IN (:settingLabelSearchKeys)')
                ->setParameter('settingLabelSearchKeys', $matchingKeys);
        }

        return $queryBuilder;
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
}
