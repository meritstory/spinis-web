<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Admin;

use App\Entity\Admin;
use App\Entity\Complaint;
use App\Entity\HealthCareInstitution;
use App\Entity\HealthCareInstitutionSourceEnum;
use App\Entity\RoleEnum;
use App\Enum\ComplaintStatusEnum;
use App\Enum\ComplaintTermEnum;
use App\Enum\ComplaintTypeEnum;
use App\Repository\AdminRepository;
use App\Repository\HealthCareInstitutionRepository;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Behat\Step\Then;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Webmozart\Assert\Assert;

final class ComplaintContext extends RawMinkContext implements Context
{
    private const string DEFAULT_INSTITUTION_TITLE = 'Testinė poliklinika';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly HealthCareInstitutionRepository $healthCareInstitutionRepository,
        private readonly AdminRepository $adminRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    #[Given('a complaint exists with number :number')]
    public function aComplaintExists(string $number): void
    {
        $complaint = (new Complaint())
            ->setNumber($number)
            ->setHealthCareInstitution($this->findOrCreateHealthCareInstitution(self::DEFAULT_INSTITUTION_TITLE))
            ->setType(ComplaintTypeEnum::PATIENT_RIGHTS->value)
            ->setStatus(ComplaintStatusEnum::SUBMITTED->value)
            ->setTermStatus(ComplaintTermEnum::ON_TIME->value)
            ->setSpecialist($this->findOrCreateSpecialist('Jonas', 'Jonaitis'));

        $this->entityManager->persist($complaint);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    #[Given('I visit the admin complaints list page')]
    public function iVisitTheAdminComplaintsListPage(): void
    {
        $this->getClient()->request('GET', '/admin/complaint');
    }

    #[Then('I should be on the admin complaints list page')]
    public function iShouldBeOnTheAdminComplaintsListPage(): void
    {
        $this->assertSession()->addressMatches('#/admin/complaint(?:\?.*)?$#');
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

    private function getClient(): KernelBrowser
    {
        $client = $this->getSession()->getDriver()->getClient();
        Assert::isInstanceOf($client, KernelBrowser::class);

        return $client;
    }
}
