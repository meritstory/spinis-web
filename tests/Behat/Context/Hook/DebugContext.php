<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Hook;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Hook\AfterStep;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Testwork\Tester\Result\TestResult;

final class DebugContext extends RawMinkContext implements Context
{
    #[AfterStep]
    public function dumpPageOnFailure(AfterStepScope $scope): void
    {
        if ($scope->getTestResult()->getResultCode() !== TestResult::FAILED) {
            return;
        }

        $session = $this->getSession();
        echo "\n----- DEBUG: request/response for failed step -----\n";
        echo 'URL: ' . $session->getCurrentUrl() . "\n";
        echo 'Status: ' . $session->getStatusCode() . "\n";
        echo substr($session->getPage()->getContent(), 0, 4000) . "\n";
        echo "----- END DEBUG -----\n";
    }
}