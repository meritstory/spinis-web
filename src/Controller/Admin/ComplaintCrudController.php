<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Complaint;
use App\Entity\RoleEnum;
use App\Enum\ComplaintStatusEnum;
use App\Enum\ComplaintTermEnum;
use App\Enum\ComplaintTypeEnum;
use App\Service\Admin\ComplaintBadgeHelper;
use App\Service\Admin\LabelledEnumHelper;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @extends AbstractCrudController<Complaint>
 */
#[IsGranted(RoleEnum::DEPARTMENT_HEAD->value)]
class ComplaintCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly LabelledEnumHelper $labelledEnumHelper,
        private readonly ComplaintBadgeHelper $complaintBadgeHelper,
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
            ->setPageTitle(Crud::PAGE_DETAIL, 'complaint.page.detail')
            ->setSearchFields(['number', 'healthCareInstitution.title', 'specialist.firstName', 'specialist.lastName'])
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setDefaultRowAction(Action::DETAIL)
            ->setPaginatorPageSize(10);
    }

    public function configureActions(Actions $actions): Actions
    {
        $selectionBatchAction = Action::new('selection', false, 'internal:check')
            ->createAsBatchAction()
            ->linkToCrudAction('selectionBatch');

        return $actions
            ->disable(Action::NEW, Action::EDIT, Action::DELETE, Action::BATCH_DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->addBatchAction($selectionBatchAction)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT);
    }

    /**
     * @param AdminContext<Complaint> $context
     * @param BatchActionDto<Complaint> $batchActionDto
     */
    #[AdminRoute(path: '/batch-selection', options: ['methods' => [Request::METHOD_POST]])]
    public function selectionBatch(AdminContext $context, BatchActionDto $batchActionDto): Response
    {
        unset($context, $batchActionDto);

        return $this->redirectToRoute('admin_complaint_index');
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
        yield TextField::new('type')
            ->setLabel('complaint.field.type')
            ->formatValue(fn (?string $value): string => $this->labelledEnumHelper->formatValue($value, ComplaintTypeEnum::class));
        yield DateTimeField::new('createdAt')
            ->setLabel('complaint.field.created_at')
            ->setFormat('yyyy-MM-dd');
        yield TextField::new('termStatus')
            ->setLabel('complaint.field.term')
            ->renderAsHtml()
            ->formatValue(fn (?string $value, ?Complaint $entity): string => $this->complaintBadgeHelper->formatTerm(
                $value,
                $entity?->getStatus(),
            ));
        yield TextField::new('status')
            ->setLabel('complaint.field.status')
            ->renderAsHtml()
            ->formatValue(fn (?string $value): string => $this->complaintBadgeHelper->format($value, ComplaintStatusEnum::class));

        yield AssociationField::new('specialist')
            ->setLabel('complaint.field.specialist')
            ->setTemplatePath('admin/field/plain_association.html.twig')
            ->formatValue(static fn (mixed $value, ?Complaint $complaint): string => $complaint?->getSpecialist() !== null
                ? (string) $complaint->getSpecialist()
                : '—');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
            ->leftJoin('entity.healthCareInstitution', 'complaintHealthCareInstitution')
            ->addSelect('complaintHealthCareInstitution')
            ->leftJoin('entity.specialist', 'complaintSpecialist')
            ->addSelect('complaintSpecialist');
    }
}
