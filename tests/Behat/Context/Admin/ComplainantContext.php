<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Admin;

use App\Entity\Complainant;
use App\Repository\ComplainantRepository;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class ComplainantContext extends RawMinkContext implements Context
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ComplainantRepository $complainantRepository,
    ) {
    }

    #[Given('a complainant exists with first name :firstName and last name :lastName')]
    public function aComplainantExistsWithFirstNameAndLastName(string $firstName, string $lastName): void
    {
        $personalCode = (string) random_int(38001010000, 38001999999);

        $complainant = new Complainant()
            ->setPersonalCode($personalCode)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail(strtolower($firstName).'@example.com')
            ->setPhone('+37060000000')
            ->setAddress('Vilnius');

        $this->entityManager->persist($complainant);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    #[Given('I open the admin complainants section from the menu')]
    public function iOpenTheAdminComplainantsSectionFromTheMenu(): void
    {
        $client = $this->getClient();

        if (!str_contains($client->getRequest()->getPathInfo(), '/admin')) {
            $client->request('GET', '/admin');
        }

        $client->click($client->getCrawler()->selectLink('Pareiškėjai')->link());
    }

    #[Given('I visit the admin complainants list page')]
    public function iVisitTheAdminComplainantsListPage(): void
    {
        $this->getClient()->request('GET', '/admin/complainant');
    }

    #[Given('I search admin complainants for :query')]
    public function iSearchAdminComplainantsFor(string $query): void
    {
        $this->getClient()->request('GET', '/admin/complainant', ['query' => $query]);
    }

    #[Given('I sort admin complainants by first name')]
    public function iSortAdminComplainantsByFirstName(): void
    {
        $client = $this->getClient();
        $link = $client->getCrawler()
            ->filterXPath('//thead//a[contains(normalize-space(.), "Vardas")]')
            ->link();

        $client->click($link);
    }

    #[Given('I sort admin complainants by last name')]
    public function iSortAdminComplainantsByLastName(): void
    {
        $client = $this->getClient();
        $link = $client->getCrawler()
            ->filterXPath('//thead//a[contains(normalize-space(.), "Pavardė")]')
            ->link();

        $client->click($link);
    }

    #[Given('I open the admin complainant detail page for :firstName :lastName')]
    public function iOpenTheAdminComplainantDetailPageFor(string $firstName, string $lastName): void
    {
        $client = $this->getClient();
        $row = $client->getCrawler()->filterXPath(sprintf(
            '//table[contains(@class, "datagrid")]//tr[.//td[@data-column="firstName" and normalize-space()="%s"] and .//td[@data-column="lastName" and normalize-space()="%s"]]',
            $firstName,
            $lastName,
        ));
        Assert::greaterThan($row->count(), 0, sprintf('Complainant "%s %s" not found in list.', $firstName, $lastName));

        $detailUrl = $row->attr('data-default-action-url');
        Assert::notNull($detailUrl);
        $client->request('GET', $detailUrl);
    }

    #[Given('the admin complainants list is open')]
    public function theAdminComplainantsListIsOpen(): void
    {
        Assert::same(Response::HTTP_OK, $this->getClient()->getResponse()->getStatusCode());
        $this->assertSession()->addressMatches('#/admin/complainant($|\\?)#');
        $this->assertSession()->pageTextContains('Pareiškėjai');
        $this->assertSession()->pageTextContains('Peržiūrėti');
        $this->assertSession()->pageTextNotContains('Sukurti');
        $this->assertSession()->pageTextNotContains('Ištrinti');
    }

    #[Given('complainant :firstName :lastName should be visible in the complainants list')]
    public function complainantShouldBeVisibleInTheComplainantsList(string $firstName, string $lastName): void
    {
        $pageText = $this->getClient()->getCrawler()->filter('table.datagrid')->text('');
        Assert::true(str_contains($pageText, $firstName) && str_contains($pageText, $lastName));
    }

    #[Given('complainant :firstName :lastName should not be visible in the complainants list')]
    public function complainantShouldNotBeVisibleInTheComplainantsList(string $firstName, string $lastName): void
    {
        $pageText = $this->getClient()->getCrawler()->filter('table.datagrid')->text('');
        Assert::false(str_contains($pageText, $firstName) && str_contains($pageText, $lastName));
    }

    #[Given('complainants should appear in this order:')]
    public function complainantsShouldAppearInThisOrder(TableNode $complainants): void
    {
        $firstNames = $this->getClient()->getCrawler()->filter('table.datagrid tbody tr td[data-column="firstName"]');
        Assert::greaterThan($firstNames->count(), 0, 'Could not find firstName cells in complainants table.');

        $actualNames = [];
        foreach ($firstNames as $node) {
            $actualNames[] = trim($node->textContent ?? '');
        }

        $expectedNames = array_map(static fn (array $row): string => trim($row[0]), $complainants->getRows());
        Assert::same(
            $expectedNames,
            $actualNames,
            sprintf('Expected %s, got %s.', json_encode($expectedNames), json_encode($actualNames)),
        );
    }

    #[Given('I should be on the admin complainant detail page for :firstName :lastName')]
    public function iShouldBeOnTheAdminComplainantDetailPageFor(string $firstName, string $lastName): void
    {
        $complainant = $this->complainantRepository->findOneBy([
            'firstName' => $firstName,
            'lastName' => $lastName,
        ]);
        Assert::notNull($complainant);
        Assert::notNull($complainant->getId());

        Assert::same(Response::HTTP_OK, $this->getClient()->getResponse()->getStatusCode());
        $this->assertSession()->addressMatches('#/admin/complainant/'.$complainant->getId().'#');
        $this->assertSession()->pageTextContains($firstName);
        $this->assertSession()->pageTextContains($lastName);
        $this->assertSession()->pageTextNotContains('Ištrinti');
    }

    private function getClient(): KernelBrowser
    {
        $client = $this->getSession()->getDriver()->getClient();
        Assert::isInstanceOf($client, KernelBrowser::class);

        return $client;
    }
}
