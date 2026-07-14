<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Api;

use App\Entity\Faq;
use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Doctrine\ORM\EntityManagerInterface;

final readonly class FaqContext implements Context
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Given('faq with question :question, answer :answer and position :position exists')]
    public function faqExists(string $question, string $answer, string $position): void
    {
        $faq = (new Faq())
            ->setQuestion($question)
            ->setAnswer($answer)
            ->setPosition((int) $position);

        $this->entityManager->persist($faq);
        $this->entityManager->flush();
    }
}
