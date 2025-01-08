<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Hook;

use Behat\Behat\Context\Context;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Logging\Middleware;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\NullLogger;

final class DoctrineORMContext implements Context
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @BeforeScenario
     */
    public function purgeDatabase(): void
    {
        $this->entityManager->getConnection()->getConfiguration()->setMiddlewares([new Middleware(new NullLogger())]);

        $purger = new ORMPurger($this->entityManager);
        $purger->purge();
        $this->entityManager->clear();
    }
}
