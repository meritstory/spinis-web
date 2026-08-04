<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Admin;

use App\Entity\Admin;
use App\Entity\Complaint;
use App\Entity\ComplaintAttachment;
use App\Entity\ComplaintStatusHistory;
use App\Entity\Complainant;
use App\Entity\HealthCareInstitution;
use App\Entity\HealthCareInstitutionSourceEnum;
use App\Entity\RoleEnum;
use App\Entity\StoredFile;
use App\Enum\ComplaintAttachmentTypeEnum;
use App\Enum\ComplaintStatusEnum;
use App\Enum\ComplaintTermEnum;
use App\Enum\ComplaintTypeEnum;
use App\Repository\AdminRepository;
use App\Repository\ComplaintRepository;
use App\Repository\HealthCareInstitutionRepository;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemOperator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Ulid;
use Webmozart\Assert\Assert;

final class ComplaintContext extends RawMinkContext implements Context
{
    private const string DEFAULT_INSTITUTION_TITLE = 'Testinė poliklinika';
    private const string DEFAULT_SPECIALIST_FIRST_NAME = 'Jonas';
    private const string DEFAULT_SPECIALIST_LAST_NAME = 'Jonaitis';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly HealthCareInstitutionRepository $healthCareInstitutionRepository,
        private readonly AdminRepository $adminRepository,
        private readonly ComplaintRepository $complaintRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        #[Target('s3.storage')]
        private readonly FilesystemOperator $storage,
    ) {
    }

    #[Given('a complaint exists with number :number')]
    public function aComplaintExists(string $number): void
    {
        $complaint = $this->withSubmittedDefaults($this->newComplaint($number))
            ->setSpecialist($this->defaultSpecialist());

        $this->persistComplaint($complaint);
    }

    #[Given('a full complaint exists with number :number')]
    public function aFullComplaintExists(string $number): void
    {
        $patient = $this->createComplainant('Petras', 'Petraitis', '39001010000');
        $representative = $this->createComplainant('Ona', 'Onaitė', '49001010000');
        $specialist = $this->defaultSpecialist();

        $complaint = $this->withSubmittedDefaults($this->newComplaint($number))
            ->setTermDate(new \DateTimeImmutable('+30 days'))
            ->setComplaintDate(new \DateTimeImmutable('2026-01-15'))
            ->setEventDate(new \DateTimeImmutable('2026-01-10'))
            ->setRelatedSpecialists('Dr. Smith')
            ->setComplaintDescription('Skundo aprašymas test')
            ->setDisagreementDescription('Nesutinkama informacija test')
            ->setExpectedResult('Laukiamas rezultatas test')
            ->setSubmittedByRepresentative(false)
            ->setPatient($patient)
            ->setRepresentative($representative)
            ->setSpecialist($specialist);

        $complaint->addStatusHistory(
            $this->newStatusHistory($complaint, ComplaintStatusEnum::SUBMITTED, new \DateTimeImmutable('2026-01-15 10:00:00')),
        );

        $this->addAttachment($complaint, $specialist, 'patient-id.pdf', ComplaintAttachmentTypeEnum::PATIENT_ID_DOCUMENT);
        $this->addAttachment($complaint, $specialist, 'institution-copy.pdf', ComplaintAttachmentTypeEnum::INSTITUTION_SUBMISSION);
        $this->addAttachment($complaint, $specialist, 'institution-response.pdf', ComplaintAttachmentTypeEnum::INSTITUTION_RESPONSE);

        $this->persistComplaint($complaint);
    }

    #[Given('a full complaint submitted by representative exists with number :number')]
    public function aFullComplaintByRepresentativeExists(string $number): void
    {
        $patient = $this->createComplainant('Petras', 'Petraitis', '39001010001');
        $representative = $this->createComplainant('Ona', 'Onaitė', '49001010001');
        $specialist = $this->defaultSpecialist();

        $complaint = $this->newComplaint($number)
            ->setType(ComplaintTypeEnum::DAMAGE_COMPENSATION->value)
            ->setStatus(ComplaintStatusEnum::IN_REVIEW->value)
            ->setTermStatus(ComplaintTermEnum::APPROACHING->value)
            ->setTermDate(new \DateTimeImmutable('+30 days'))
            ->setComplaintDate(new \DateTimeImmutable('2026-01-15'))
            ->setEventDate(new \DateTimeImmutable('2026-01-10'))
            ->setRelatedSpecialists('Dr. Smith')
            ->setComplaintDescription('Skundo aprašymas test')
            ->setDisagreementDescription('Nesutinkama informacija test')
            ->setExpectedResult('Laukiamas rezultatas test')
            ->setSubmittedByRepresentative(true)
            ->setPatient($patient)
            ->setRepresentative($representative)
            ->setSpecialist($specialist);

        $complaint->addStatusHistory(
            $this->newStatusHistory($complaint, ComplaintStatusEnum::SUBMITTED, new \DateTimeImmutable('2026-01-10 09:00:00')),
        );
        $complaint->addStatusHistory(
            $this->newStatusHistory($complaint, ComplaintStatusEnum::IN_REVIEW, new \DateTimeImmutable('2026-02-01 12:00:00')),
        );

        $this->addAttachment($complaint, $specialist, 'patient-id.pdf', ComplaintAttachmentTypeEnum::PATIENT_ID_DOCUMENT);
        $this->addAttachment($complaint, $specialist, 'institution-copy.pdf', ComplaintAttachmentTypeEnum::INSTITUTION_SUBMISSION);
        $this->addAttachment($complaint, $specialist, 'institution-response.pdf', ComplaintAttachmentTypeEnum::INSTITUTION_RESPONSE);
        $this->addAttachment($complaint, $specialist, 'representation.pdf', ComplaintAttachmentTypeEnum::REPRESENTATION_PROOF);

        $this->persistComplaint($complaint);
    }

    #[Given('I visit the admin complaints list page')]
    public function iVisitTheAdminComplaintsListPage(): void
    {
        $this->getClient()->request('GET', '/admin/complaint');
    }

    #[Given('I visit the admin complaint edit page for :number')]
    public function iVisitTheAdminComplaintEditPage(string $number): void
    {
        $this->requestComplaintEditPage($this->requireComplaint($number));
    }

    #[Then('I should be on the admin complaint edit page for :number')]
    public function iShouldBeOnTheAdminComplaintEditPage(string $number): void
    {
        $complaint = $this->requireComplaint($number);
        $this->assertSession()->addressMatches(
            sprintf('#%s#', preg_quote($this->complaintAdminPath($complaint, 'edit'), '#')),
        );
    }

    #[Then('I should be on the admin complaints list page')]
    public function iShouldBeOnTheAdminComplaintsListPage(): void
    {
        $this->assertSession()->addressMatches('#/admin/complaint(?:\?.*)?$#');
    }

    #[When('I open complaint :number from the complaints list')]
    public function iOpenComplaintFromTheComplaintsList(string $number): void
    {
        $client = $this->getClient();
        $linkNode = $client->getCrawler()->filter('table tbody tr')->reduce(
            static fn (\Symfony\Component\DomCrawler\Crawler $row): bool => str_contains($row->text(), $number),
        )->filter('a[href*="/edit"]')->first();
        Assert::true($linkNode->count() > 0, sprintf('Complaint link for "%s" not found on list page.', $number));
        $client->click($linkNode->link());
    }

    #[When('I download complaint attachment :filename from the edit page')]
    public function iDownloadComplaintAttachmentFromEditPage(string $filename): void
    {
        $client = $this->getClient();
        $linkNode = $client->getCrawler()->filter('a')->reduce(
            static fn (\Symfony\Component\DomCrawler\Crawler $node): bool => str_contains($node->text(), $filename),
        )->first();
        Assert::true($linkNode->count() > 0, sprintf('Attachment link "%s" not found on edit page.', $filename));

        $href = $linkNode->attr('href');
        Assert::notNull($href);
        Assert::true((bool) preg_match('#^/files/[0-9a-f-]{36}$#', $href));
        $client->request('GET', $href);
    }

    #[When('I save complaint :number from the edit page and return to the list with status :status')]
    public function iSaveComplaintFromEditAndReturn(string $number, string $status): void
    {
        $this->submitComplaintEditForm($number, 'saveAndReturn', $status);
    }

    #[When('I save complaint :number from the edit page and continue editing with status :status')]
    public function iSaveComplaintFromEditAndContinue(string $number, string $status): void
    {
        $this->submitComplaintEditForm($number, 'saveAndContinue', $status);
    }

    #[When('I cancel unsaved complaint changes on the edit page for :number')]
    public function iCancelUnsavedComplaintChangesOnEditPage(string $number): void
    {
        $complaint = $this->requireComplaint($number);
        $client = $this->getClient();
        $client->request('GET', $this->complaintAdminPath($complaint, 'cancel-changes'));
        $response = $client->getResponse();
        if ($response->isRedirect()) {
            $client->followRedirect();
        }
    }

    #[When('I change complaint :number status on the edit page to :status without saving')]
    public function iChangeComplaintStatusOnEditPageWithoutSaving(string $number, string $status): void
    {
        $complaint = $this->requireComplaint($number);
        $this->requestComplaintEditPage($complaint);

        $client = $this->getClient();
        $formNode = $client->getCrawler()->filter('form.ea-edit-form');
        Assert::greaterThan($formNode->count(), 0, 'Complaint edit form was not found on the page.');

        $form = $formNode->form();
        $statusValue = ComplaintStatusEnum::fromName(strtoupper($status))->value;
        $fieldNames = array_keys($form->getValues());
        $statusFieldName = $this->findComplaintFormFieldNameBySuffix($fieldNames, '[status]');
        Assert::notNull($statusFieldName, 'Complaint status field was not found on the edit form.');
        $form[$statusFieldName]->setValue($statusValue);
    }

    #[When('I follow the complaints breadcrumb from the complaint edit page')]
    public function iFollowTheComplaintsBreadcrumbFromComplaintEditPage(): void
    {
        $client = $this->getClient();
        $linkNode = $client->getCrawler()->filter('.ea-complaint-breadcrumb a')->first();
        Assert::true($linkNode->count() > 0, 'Complaints breadcrumb link was not found on the edit page.');
        $client->click($linkNode->link());
    }

    #[Then('the complaint edit page should show action confirmation modal labels')]
    public function theComplaintEditPageShouldShowActionConfirmationModalLabels(): void
    {
        $html = $this->getClient()->getResponse()->getContent();
        Assert::notNull($html);
        Assert::contains($html, 'Ar tikrai norite atšaukti pakeitimus?');
        Assert::contains($html, 'Ar tikrai norite išsaugoti pakeitimus?');
        Assert::contains($html, 'id="modal-action-confirmation-button"');
        Assert::contains($html, 'Ne</span>');
        Assert::contains($html, 'Taip');

        $crawler = $this->getClient()->getCrawler();
        $cancelAction = $crawler->filter('a[data-action-confirmation="true"][href*="cancel-changes"]');
        Assert::true($cancelAction->count() > 0, 'Cancel changes action link was not found on the edit page.');
        Assert::contains($cancelAction->text(), 'Atšaukti pakeitimus');
        Assert::false($cancelAction->attr('form') !== null && $cancelAction->attr('form') !== '', 'Cancel action must not be tied to the edit form.');

        $pageActions = $crawler->filter('.content-header .page-actions');
        Assert::same(1, $pageActions->filter('button.action-saveAndReturn[data-action-confirmation="true"]')->count());
        Assert::same(1, $pageActions->filter('button.action-saveAndContinue[data-action-confirmation="true"]')->count());
    }

    #[Then('the complaint edit page should show EasyAdmin save actions tied to the edit form')]
    public function theComplaintEditPageShouldShowEasyAdminSaveActionsTiedToTheEditForm(): void
    {
        $editFormId = 'edit-Complaint-form';
        $crawler = $this->getClient()->getCrawler();

        $formNode = $crawler->filter('form.ea-edit-form');
        Assert::same(1, $formNode->count(), 'Complaint edit form was not found on the page.');
        Assert::same($editFormId, $formNode->attr('id'));

        $pageActions = $crawler->filter('.content-header .page-actions');
        Assert::same(1, $pageActions->count(), 'Complaint edit page actions were not found in the content header.');

        $saveAndReturn = $pageActions->filter('button.action-saveAndReturn');
        $saveAndContinue = $pageActions->filter('button.action-saveAndContinue');
        Assert::same(1, $saveAndReturn->count(), 'Save action button was not found in page actions.');
        Assert::same(1, $saveAndContinue->count(), 'Save and continue action button was not found in page actions.');
        Assert::same($editFormId, $saveAndReturn->attr('form'));
        Assert::same($editFormId, $saveAndContinue->attr('form'));
    }

    #[Then('complaint :number on the edit page should show status :status')]
    public function complaintOnEditPageShouldShowStatus(string $number, string $status): void
    {
        $expectedValue = ComplaintStatusEnum::fromName(strtoupper($status))->value;

        $form = $this->getClient()->getCrawler()->filter('form.ea-edit-form')->form();
        $statusFieldName = $this->findComplaintFormFieldNameBySuffix(array_keys($form->getValues()), '[status]');
        Assert::notNull($statusFieldName, 'Complaint status field was not found on the edit page.');
        Assert::same($form->get($statusFieldName)->getValue(), $expectedValue);
    }

    #[Then('the complaint edit page term date field should allow only future dates')]
    public function theComplaintEditPageTermDateFieldShouldAllowOnlyFutureDates(): void
    {
        $inputNode = $this->getClient()->getCrawler()->filter('input[name="Complaint[termDate]"]')->first();
        Assert::true($inputNode->count() > 0, 'Term date input was not found on the edit page.');
        Assert::same($inputNode->attr('type'), 'date');
        $min = $inputNode->attr('min');
        Assert::notNull($min);
        Assert::same($min, (new \DateTimeImmutable('today'))->format('Y-m-d'));
    }

    #[Then('complaint :number should have status :status')]
    public function complaintShouldHaveStatus(string $number, string $status): void
    {
        $this->entityManager->clear();
        $expected = ComplaintStatusEnum::fromName(strtoupper($status))->value;
        Assert::same($this->requireComplaint($number)->getStatus(), $expected);
    }

    #[Then('complaint :number should have :count status history records')]
    public function complaintShouldHaveStatusHistoryCount(string $number, int $count): void
    {
        $this->entityManager->clear();
        Assert::count($this->requireComplaint($number)->getStatusHistory(), $count);
    }

    #[Given('I search the admin complaints list for :query')]
    public function iSearchTheAdminComplaintsList(string $query): void
    {
        $this->getClient()->request('GET', '/admin/complaint', [
            'query' => $query,
        ]);
    }

    private function findOrCreateHealthCareInstitution(string $title): HealthCareInstitution
    {
        $existing = $this->healthCareInstitutionRepository->findOneBy(['title' => $title]);
        if ($existing !== null) {
            return $existing;
        }

        $maxCode = $this->healthCareInstitutionRepository->createQueryBuilder('institution')
            ->select('MAX(institution.code)')
            ->getQuery()
            ->getSingleScalarResult();

        $healthCareInstitution = (new HealthCareInstitution())
            ->setTitle($title)
            ->setCode(max(1, ($maxCode !== null ? (int) $maxCode : 0) + 1))
            ->setSource(HealthCareInstitutionSourceEnum::LSPSKP);

        $this->entityManager->persist($healthCareInstitution);

        return $healthCareInstitution;
    }

    private function defaultSpecialist(): Admin
    {
        return $this->findOrCreateSpecialist(
            self::DEFAULT_SPECIALIST_FIRST_NAME,
            self::DEFAULT_SPECIALIST_LAST_NAME,
        );
    }

    private function requestComplaintEditPage(Complaint $complaint): void
    {
        $this->getClient()->request('GET', $this->complaintAdminPath($complaint, 'edit'));
    }

    private function complaintAdminPath(Complaint $complaint, string $suffix): string
    {
        return sprintf('/admin/complaint/%d/%s', $complaint->getId(), $suffix);
    }

    private function withSubmittedDefaults(Complaint $complaint): Complaint
    {
        return $complaint
            ->setType(ComplaintTypeEnum::PATIENT_RIGHTS->value)
            ->setStatus(ComplaintStatusEnum::SUBMITTED->value)
            ->setTermStatus(ComplaintTermEnum::ON_TIME->value);
    }

    private function newStatusHistory(
        Complaint $complaint,
        ComplaintStatusEnum $status,
        \DateTimeImmutable $changedAt,
    ): ComplaintStatusHistory {
        return (new ComplaintStatusHistory())
            ->setComplaint($complaint)
            ->setStatus($status->value)
            ->setChangedAt($changedAt);
    }

    private function findOrCreateSpecialist(string $firstName, string $lastName): Admin
    {
        $email = sprintf(
            '%s.%s@example.com',
            strtolower($firstName),
            strtolower($lastName),
        );

        $existing = $this->adminRepository->findOneByEmail($email);
        if ($existing !== null) {
            return $existing;
        }

        $admin = (new Admin())
            ->setEmail($email)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setRoles([RoleEnum::SPECIALIST->value])
            ->setActive(true)
            ->setEmailTwoFactorEnabled(false);

        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, 'secret'));
        $this->entityManager->persist($admin);

        return $admin;
    }

    private function createComplainant(string $firstName, string $lastName, string $personalCode): Complainant
    {
        $complainant = (new Complainant())
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setPersonalCode($personalCode)
            ->setEmail(strtolower($firstName).'.'.strtolower($lastName).'@example.com')
            ->setPhone('+37060000000')
            ->setAddress('Gatvė 1, Vilnius');

        $this->entityManager->persist($complainant);

        return $complainant;
    }

    private function addAttachment(
        Complaint $complaint,
        Admin $admin,
        string $originalName,
        ComplaintAttachmentTypeEnum $type,
    ): void {
        $path = 'behat-'.new Ulid().'.pdf';
        $this->storage->write($path, 'pdf-content', ['mimetype' => 'application/pdf']);

        $storedFile = (new StoredFile())
            ->setUploadedByAdmin($admin)
            ->setFileName($path)
            ->setOriginalName($originalName)
            ->setFileSize(strlen('pdf-content'))
            ->setMimeType('application/pdf');

        $attachment = (new ComplaintAttachment())
            ->setComplaint($complaint)
            ->setStoredFile($storedFile)
            ->setType($type->value);

        $complaint->addAttachment($attachment);
        $this->entityManager->persist($storedFile);
        $this->entityManager->persist($attachment);
    }

    private function submitComplaintEditForm(string $number, string $button, string $status): void
    {
        $complaint = $this->requireComplaint($number);

        $client = $this->getClient();
        $this->requestComplaintEditPage($complaint);
        $formNode = $client->getCrawler()->filter('form.ea-edit-form');
        Assert::greaterThan($formNode->count(), 0, 'Complaint edit form was not found on the page.');

        $form = $formNode->form();
        $formFieldNames = array_keys($form->all());
        $tokenNode = $client->getCrawler()->filter('form.ea-edit-form input[type="hidden"][name$="[_token]"]')->first();
        Assert::true($tokenNode->count() > 0, 'Complaint edit form CSRF token was not found.');
        $tokenValue = $tokenNode->attr('value');
        Assert::notNull($tokenValue);

        $statusValue = ComplaintStatusEnum::fromName(strtoupper($status))->value;
        $statusFieldName = $this->findComplaintFormFieldNameBySuffix($formFieldNames, '[status]');
        Assert::notNull($statusFieldName, 'Complaint status field was not found on the edit form.');
        $form[$statusFieldName]->setValue($statusValue);

        $specialistFieldName = $this->findComplaintFormFieldNameBySuffix($formFieldNames, '[specialist][autocomplete]');
        Assert::notNull($specialistFieldName, 'Complaint specialist autocomplete field was not found.');
        $specialistAutocompleteValue = $form[$specialistFieldName]->getValue();
        Assert::notSame('', $specialistAutocompleteValue, 'Complaint specialist autocomplete value is empty on edit form.');

        $complaintData = [
            'status' => $statusValue,
            '_token' => $tokenValue,
            'specialist' => [
                'autocomplete' => $specialistAutocompleteValue,
            ],
        ];

        $termDateFieldName = $this->findComplaintFormFieldNameBySuffix($formFieldNames, '[termDate]');
        if ($termDateFieldName !== null) {
            $termDateValue = $form[$termDateFieldName]->getValue();
            if ($termDateValue !== '') {
                $complaintData['termDate'] = $termDateValue;
            }
        }

        $requestParameters = [
            'Complaint' => $complaintData,
            'ea' => [
                'newForm' => [
                    'btn' => $button,
                ],
            ],
        ];

        $client->request('POST', $form->getUri(), $requestParameters);

        $response = $client->getResponse();
        if ($response->isRedirect()) {
            $client->followRedirect();
        }
    }

    private function getClient(): KernelBrowser
    {
        $client = $this->getSession()->getDriver()->getClient();
        Assert::isInstanceOf($client, KernelBrowser::class);

        return $client;
    }

    private function requireComplaint(string $number): Complaint
    {
        $complaint = $this->complaintRepository->findOneBy(['number' => $number]);
        Assert::notNull($complaint, sprintf('Complaint "%s" was not found.', $number));
        Assert::notNull($complaint->getId());

        return $complaint;
    }

    private function newComplaint(string $number): Complaint
    {
        return (new Complaint())
            ->setNumber($number)
            ->setHealthCareInstitution($this->findOrCreateHealthCareInstitution(self::DEFAULT_INSTITUTION_TITLE));
    }

    private function persistComplaint(Complaint $complaint): void
    {
        $this->entityManager->persist($complaint);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    /**
     * @param string[] $fieldNames
     */
    private function findComplaintFormFieldNameBySuffix(array $fieldNames, string $suffix): ?string
    {
        foreach ($fieldNames as $fieldName) {
            if (str_ends_with($fieldName, $suffix)) {
                return $fieldName;
            }
        }

        return null;
    }
}
