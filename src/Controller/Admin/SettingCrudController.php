<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Setting;
use App\Enum\SettingKeyEnum;
use App\Repository\SettingRepository;
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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @extends AbstractCrudController<Setting>
 */
class SettingCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly SettingRepository $settingRepository,
        private readonly TranslatorInterface $translator,
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
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->disable(Action::DELETE);

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();

        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            yield TextField::new('key')
                ->setLabel('setting.field.key')
                ->formatValue(fn (?string $value): string => $this->formatKeyLabel($value));
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

        yield TextField::new('value')
            ->setLabel('setting.field.value')
            ->setRequired(true)
            ->setEmptyData('');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $sort = $searchDto->getSort();
        if (isset($sort['key'])) {
            $this->applyKeyLabelSort($queryBuilder, $sort['key']);
        }

        $matchingKeys = $this->findMatchingKeys(trim($searchDto->getQuery()));
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
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);

        $entity = $entityDto->getInstance();
        if ($entity instanceof Setting && $formBuilder->has('key')) {
            $formBuilder->get('key')->setData($this->formatKeyLabel($entity->getKey()));
        }

        return $formBuilder;
    }

    /**
     * @return array<string, string>
     */
    private function getAvailableKeyChoices(): array
    {
        $usedKeys = $this->settingRepository->findUsedKeys();
        $choices = [];

        foreach (SettingKeyEnum::cases() as $case) {
            if (!in_array($case->value, $usedKeys, true)) {
                $choices[$this->translator->trans($case->getLabelKey())] = $case->value;
            }
        }

        return $choices;
    }

    private function formatKeyLabel(?string $key): string
    {
        if ($key === null || $key === '') {
            return '';
        }

        $enum = SettingKeyEnum::tryFrom($key);

        return $enum !== null ? $this->translator->trans($enum->getLabelKey()) : $key;
    }

    private function applyKeyLabelSort(QueryBuilder $queryBuilder, string $direction): void
    {
        $caseParts = ['CASE'];
        $index = 0;

        foreach (SettingKeyEnum::cases() as $case) {
            $keyParameter = 'settingSortKey'.$index;
            $labelParameter = 'settingSortLabel'.$index;
            $caseParts[] = sprintf('WHEN entity.key = :%s THEN :%s', $keyParameter, $labelParameter);
            $queryBuilder
                ->setParameter($keyParameter, $case->value)
                ->setParameter($labelParameter, $this->translator->trans($case->getLabelKey()));
            ++$index;
        }

        $caseParts[] = 'ELSE entity.key END';
        $queryBuilder
            ->resetDQLPart('orderBy')
            ->addSelect(implode(' ', $caseParts).' AS HIDDEN setting_key_label_sort')
            ->addOrderBy('setting_key_label_sort', $direction)
            ->addOrderBy('entity.id', $direction);
    }

    /**
     * @return list<string>
     */
    private function findMatchingKeys(string $query): array
    {
        if ($query === '') {
            return [];
        }

        $needle = mb_strtolower($query);
        $keys = [];

        foreach (SettingKeyEnum::cases() as $case) {
            $label = mb_strtolower($this->translator->trans($case->getLabelKey()));
            if (str_contains($label, $needle)) {
                $keys[] = $case->value;
            }
        }

        return $keys;
    }
}
