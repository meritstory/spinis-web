<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use App\Entity\Faq;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Behat\Step\Then;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Webmozart\Assert\Assert;

final class HomeContext extends RawMinkContext implements Context
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Given('/^faqs exist:$/')]
    public function faqsExist(TableNode $table): void
    {
        $propertyAccessor = FeatureContext::getPropertyAccessor();

        foreach ($table as $row) {
            $faq = new Faq();

            foreach ($row as $property => $value) {
                $propertyAccessor->setValue($faq, $property, $value);
            }

            $this->entityManager->persist($faq);
        }

        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    #[Then('the FAQ questions should appear in this order:')]
    public function theFaqQuestionsShouldAppearInThisOrder(TableNode $table): void
    {
        $expectedQuestions = array_map(static fn (array $row): string => $row[0], $table->getRows());

        $actualQuestions = $this->getClient()->getCrawler()
            ->filter('details[name="faq-accordion"] summary')
            ->each(static fn ($node): string => trim($node->text()));

        Assert::same($expectedQuestions, $actualQuestions);
    }

    private function getClient(): KernelBrowser
    {
        $client = $this->getSession()->getDriver()->getClient();
        Assert::isInstanceOf($client, KernelBrowser::class);

        return $client;
    }
}