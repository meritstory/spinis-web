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

    #[Given('a faq exists with question :question, answer :answer and position :position')]
    public function aFaqExists(string $question, string $answer, string $position): void
    {
        $faq = new Faq()
            ->setQuestion($question)
            ->setAnswer($answer)
            ->setPosition((int) $position);

        $this->entityManager->persist($faq);
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