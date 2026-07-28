<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Viisp;

use App\Repository\ComplainantRepository;
use App\Tests\Behat\Support\FakeViispClient;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Behat\Step\Then;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Webmozart\Assert\Assert;

final class LoginContext extends RawMinkContext implements Context
{
    public function __construct(
        private readonly FakeViispClient $fakeViispClient,
        private readonly ComplainantRepository $complainantRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @BeforeScenario
     */
    public function resetFakeViispClient(): void
    {
        $this->fakeViispClient->reset();
    }

    #[Given('VIISP will successfully authenticate personal code :personalCode as :firstName :lastName')]
    public function viispWillSucceed(string $personalCode, string $firstName, string $lastName): void
    {
        $this->fakeViispClient->willSucceedWith($personalCode, $firstName, $lastName);
    }

    #[Given('VIISP authentication will fail')]
    public function viispWillFail(): void
    {
        $this->fakeViispClient->willFail();
    }

    #[Given('I complete VIISP login via login-submit')]
    public function iCompleteViispLoginViaLoginSubmit(): void
    {
        $client = $this->getClient();
        $client->request('GET', '/viisp/login-submit');

        $ticket = $client->getCrawler()->filter('input[name="ticket"]')->attr('value');
        Assert::string($ticket);

        $client->request('POST', '/viisp/login-postback', ['ticket' => $ticket]);
    }

    #[Then('a complainant with personal code :personalCode should exist')]
    public function aComplainantWithPersonalCodeShouldExist(string $personalCode): void
    {
        $this->entityManager->clear();

        Assert::notNull($this->complainantRepository->findOneByPersonalCode($personalCode));
    }

    private function getClient(): KernelBrowser
    {
        $client = $this->getSession()->getDriver()->getClient();
        Assert::isInstanceOf($client, KernelBrowser::class);

        return $client;
    }
}
