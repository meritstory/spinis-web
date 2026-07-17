<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Admin\Field\TinyMceField;
use App\Entity\Document;
use App\Enum\DocumentKeyEnum;
use App\Repository\DocumentRepository;
use App\Service\Admin\LabelledEnumHelper;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
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

/**
 * @extends AbstractCrudController<Document>
 */
class DocumentCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly DocumentRepository $documentRepository,
        private readonly LabelledEnumHelper $labelledEnumHelper,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Document::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('document.label.singular')
            ->setEntityLabelInPlural('menu.documents')
            ->setPageTitle(Crud::PAGE_INDEX, 'menu.documents')
            ->setPageTitle(Crud::PAGE_NEW, 'document.page.create')
            ->setPageTitle(Crud::PAGE_EDIT, 'document.page.edit')
            ->setPageTitle(Crud::PAGE_DETAIL, 'document.page.detail')
            ->setSearchFields(['title', 'key'])
            ->setDefaultSort(['title' => 'ASC'])
            ->setDefaultRowAction(Action::DETAIL)
            ->setFormOptions(['attr' => ['novalidate' => 'novalidate']]);
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets->addAssetMapperEntry(
            Asset::new('admin/tinymce-field')->onlyOnForms()
        );
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, static function (Action $action): Action {
                return $action->setLabel('document.action.create');
            })
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE);

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();

        yield TextField::new('title')
            ->setLabel('document.field.title')
            ->setRequired(true)
            ->setEmptyData('');

        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            yield TextField::new('key')
                ->setLabel('document.field.key')
                ->formatValue(fn (?string $value): string => $this->labelledEnumHelper->formatValue($value, DocumentKeyEnum::class));
        }

        if ($pageName === Crud::PAGE_NEW) {
            $availableChoices = $this->getAvailableKeyChoices();

            $keyField = ChoiceField::new('key')
                ->setLabel('document.field.key')
                ->setRequired(true)
                ->setChoices($availableChoices)
                ->setFormTypeOption('placeholder', 'document.field.key_placeholder')
                ->setFormTypeOption('empty_data', '');

            if ($availableChoices === []) {
                $keyField = $keyField->setHelp('document.all_keys_used');
            }

            yield $keyField;
        }

        if ($pageName === Crud::PAGE_EDIT) {
            yield TextField::new('key')
                ->setLabel('document.field.key')
                ->setFormTypeOption('disabled', true)
                ->setFormTypeOption('mapped', false);
        }

        yield TinyMceField::new('description')
            ->setLabel('document.field.description')
            ->hideOnIndex()
            ->setRequired(true)
            ->setFormTypeOption('empty_data', '');
    }

    /**
     * @return FormBuilderInterface<mixed>
     */
    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);

        $entity = $entityDto->getInstance();
        if ($entity instanceof Document && $formBuilder->has('key')) {
            $formBuilder->get('key')->setData($this->labelledEnumHelper->formatValue($entity->getKey(), DocumentKeyEnum::class));
        }

        return $formBuilder;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $sort = $searchDto->getSort();
        if (isset($sort['key'])) {
            $this->labelledEnumHelper->applyKeyLabelSort(
                $queryBuilder,
                'entity.key',
                $sort['key'],
                DocumentKeyEnum::class,
            );
        }

        $matchingKeys = $this->labelledEnumHelper->findMatchingValues(trim($searchDto->getQuery()), DocumentKeyEnum::class);
        if ($matchingKeys !== []) {
            $queryBuilder
                ->orWhere('entity.key IN (:documentLabelSearchKeys)')
                ->setParameter('documentLabelSearchKeys', $matchingKeys);
        }

        return $queryBuilder;
    }

    /** @return array<string, string> */
    private function getAvailableKeyChoices(): array
    {
        return $this->labelledEnumHelper->getAvailableChoices(
            DocumentKeyEnum::class,
            $this->documentRepository->findUsedKeys(),
        );
    }
}
