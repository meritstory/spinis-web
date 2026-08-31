<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Complaint;
use App\Entity\ComplaintStatusHistory;
use App\Entity\RoleEnum;
use App\Enum\ComplaintStatusEnum;
use App\Enum\ComplaintTermEnum;
use App\Enum\ComplaintTypeEnum;
use App\Repository\AdminRepository;
use App\Service\Admin\ComplaintBadgeHelper;
use App\Service\Admin\LabelledEnumHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @extends AbstractAdminCrudController<Complaint>
 */
#[IsGranted(RoleEnum::DEPARTMENT_HEAD->value)]
class ComplaintCrudController extends AbstractAdminCrudController
{
    /** @var array<int, int>|null */
    private ?array $specialistAssignedComplaintCounts = null;

    public function __construct(
        private readonly LabelledEnumHelper $labelledEnumHelper,
        private readonly ComplaintBadgeHelper $complaintBadgeHelper,
        private readonly AdminRepository $adminRepository,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Complaint::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('complaint.label.singular')
            ->setEntityLabelInPlural('menu.complaints')
            ->setPageTitle(Crud::PAGE_INDEX, 'menu.complaints')
            ->setSearchFields(['number', 'healthCareInstitution.title', 'specialist.firstName', 'specialist.lastName'])
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setDefaultRowAction(Action::EDIT)
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(10)
            ->overrideTemplate('crud/edit', 'admin/crud/complaint_edit.html.twig');
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets->addAssetMapperEntry(
            Asset::new('admin/complaint-edit-form')->onlyOnForms(),
        );
    }

    public function configureActions(Actions $actions): Actions
    {
        $cancelChanges = Action::new('cancelChanges', 'complaint.action.cancel_changes')
            ->linkToCrudAction(Action::EDIT)
            ->asTextLink()
            ->askConfirmation('complaint.confirm.cancel_changes', 'complaint.confirm.yes')
            ->setTemplatePath('admin/crud/cancel_changes_action.html.twig');

        return $actions
            ->disable(Action::NEW, Action::DELETE, Action::BATCH_DELETE, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, $cancelChanges)
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, fn (Action $action): Action => $action
                ->setLabel('complaint.action.save_and_continue')
                ->askConfirmation('complaint.confirm.save', 'complaint.confirm.yes'))
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, fn (Action $action): Action => $action
                ->setLabel('complaint.action.save')
                ->askConfirmation('complaint.confirm.save', 'complaint.confirm.yes'));
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(
                ChoiceFilter::new('type', 'complaint.field.type')
                    ->setChoices($this->labelledEnumHelper->getChoicesForEnum(ComplaintTypeEnum::class)),
            )
            ->add(
                ChoiceFilter::new('status', 'complaint.field.status')
                    ->setChoices($this->labelledEnumHelper->getChoicesForEnum(ComplaintStatusEnum::class)),
            )
            ->add(
                ChoiceFilter::new('termStatus', 'complaint.field.term')
                    ->setChoices($this->labelledEnumHelper->getChoicesForEnum(ComplaintTermEnum::class)),
            );
    }

    public function configureFields(string $pageName): iterable
    {
        if ($pageName === Crud::PAGE_EDIT) {
            yield from $this->configureEditFields();

            return;
        }

        yield TextField::new('number')
            ->setLabel('complaint.field.number')
            ->renderAsHtml()
            ->formatValue(static fn (?string $value): string => $value !== null && $value !== ''
                ? sprintf(
                    '<span class="ea-complaint-number">%s</span>',
                    htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
                )
                : '');
        yield AssociationField::new('healthCareInstitution')
            ->setLabel('complaint.field.institution');
        yield ChoiceField::new('type')
            ->setLabel('complaint.field.type')
            ->setChoices($this->labelledEnumHelper->getEnumChoicesForEnum(ComplaintTypeEnum::class))
            ->formatValue(fn (ComplaintTypeEnum|string|null $value): string => $this->labelledEnumHelper->formatValue(
                $value,
                ComplaintTypeEnum::class,
            ));
        yield DateTimeField::new('createdAt')
            ->setLabel('complaint.field.created_at')
            ->setFormat('yyyy-MM-dd');
        yield ChoiceField::new('termStatus')
            ->setLabel('complaint.field.term')
            ->setChoices($this->labelledEnumHelper->getEnumChoicesForEnum(ComplaintTermEnum::class))
            ->escapeHtml(false)
            ->formatValue(fn (ComplaintTermEnum|string|null $value, ?Complaint $entity): string => $this->complaintBadgeHelper->formatTerm(
                $value,
                $entity?->getStatus(),
            ));
        yield ChoiceField::new('status')
            ->setLabel('complaint.field.status')
            ->setChoices($this->labelledEnumHelper->getEnumChoicesForEnum(ComplaintStatusEnum::class))
            ->escapeHtml(false)
            ->formatValue(fn (ComplaintStatusEnum|string|null $value): string => $this->complaintBadgeHelper->format($value, ComplaintStatusEnum::class));

        yield AssociationField::new('specialist')
            ->setLabel('complaint.field.specialist')
            ->setTemplatePath('admin/field/plain_association.html.twig')
            ->formatValue(static fn (mixed $value, ?Complaint $complaint): string => self::formatOrDash(
                $complaint?->getSpecialist() !== null ? (string) $complaint->getSpecialist() : null,
            ));
    }

    /**
     * @return iterable<\EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface>
     */
    private function configureEditFields(): iterable
    {
        yield AssociationField::new('specialist', 'complaint.field.specialist')
            ->setQueryBuilder(
                fn (QueryBuilder $queryBuilder): QueryBuilder => $this->adminRepository->restrictQueryBuilderToActiveSpecialists(
                    $queryBuilder,
                    'entity',
                    $this->currentComplaintSpecialistId(),
                ),
            )
            ->setFormTypeOption(
                'choice_label',
                fn (?Admin $admin): string => $this->formatSpecialistChoiceLabel($admin),
            )
            ->setRequired(false);
        yield ChoiceField::new('status', 'complaint.field.status')
            ->setChoices($this->labelledEnumHelper->getEnumChoicesForEnum(ComplaintStatusEnum::class))
            ->setFormTypeOption(
                'choice_value',
                static fn (?ComplaintStatusEnum $status): string => $status === null ? '' : $status->value,
            );
        yield DateField::new('termDate', 'complaint.field.term_date')
            ->renderAsNativeWidget()
            ->setFormTypeOption('attr', ['min' => self::todayIsoDate()]);
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
            ->leftJoin('entity.healthCareInstitution', 'complaintHealthCareInstitution')
            ->addSelect('complaintHealthCareInstitution')
            ->leftJoin('entity.specialist', 'complaintSpecialist')
            ->addSelect('complaintSpecialist');
    }

    /**
     * @param Complaint $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $previousStatus = $entityManager->getUnitOfWork()->getOriginalEntityData($entityInstance)['status'] ?? null;

        if ($previousStatus !== $entityInstance->getStatus()) {
            $entityInstance->addStatusHistory(
                (new ComplaintStatusHistory())
                    ->setStatus($entityInstance->getStatus())
                    ->setChangedAt(new \DateTimeImmutable()),
            );
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function currentComplaintSpecialistId(): ?int
    {
        $complaint = $this->getContext()?->getEntity()?->getInstance();

        return $complaint instanceof Complaint ? $complaint->getSpecialist()?->getId() : null;
    }

    private function formatSpecialistChoiceLabel(?Admin $admin): string
    {
        if ($admin === null) {
            return '';
        }

        $specialistId = $admin->getId();
        if ($specialistId === null) {
            return $admin->getFullName();
        }

        $this->specialistAssignedComplaintCounts ??= $this->adminRepository->mapComplaintAssignmentCountsForActiveSpecialists();

        return sprintf(
            '%s — %s (%d)',
            $admin->getFullName(),
            $this->translator->trans('admin.role.specialist'),
            $this->specialistAssignedComplaintCounts[$specialistId] ?? 0,
        );
    }

    private static function formatOrDash(?string $value): string
    {
        return $value ?? '—';
    }

    private static function todayIsoDate(): string
    {
        return (new \DateTimeImmutable('today'))->format('Y-m-d');
    }
}
