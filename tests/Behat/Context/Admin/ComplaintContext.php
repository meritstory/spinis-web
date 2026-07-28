<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Admin;

use App\Entity\Complaint;
use App\Enum\ComplaintStatusEnum;
use App\Enum\ComplaintTermEnum;
use App\Enum\ComplaintTypeEnum;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Behat\Step\Then;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Webmozart\Assert\Assert;

final class ComplaintContext extends RawMinkContext implements Context
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Given('a complaint exists with number :number institution :institution type :type status :status term :term and specialist :specialist')]
    public function aComplaintExists(
        string $number,
        string $institution,
        string $type,
        string $status,
        string $term,
        string $specialist,
    ): void {
        $complaint = (new Complaint())
            ->setNumber($number)
            ->setInstitutionName($institution)
            ->setType(ComplaintTypeEnum::fromName(strtoupper($type))->value)
            ->setStatus(ComplaintStatusEnum::fromName(strtoupper($status))->value)
            ->setTermStatus(ComplaintTermEnum::fromName(strtoupper($term))->value)
            ->setSpecialist($specialist === 'none' ? null : $specialist);

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

    private function getClient(): KernelBrowser
    {
        $client = $this->getSession()->getDriver()->getClient();
        Assert::isInstanceOf($client, KernelBrowser::class);

        return $client;
    }
}
