<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Api;

use App\Tests\Behat\Context\FeatureContext;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Symfony\Component\HttpFoundation\Request;

class UserContext extends RawMinkContext implements Context
{
    public function __construct(
        private readonly FeatureContext $featureContext,
    ) {
    }

    #[Given('/^I refresh my token$/')]
    public function refreshToken(): void
    {
        $response = $this->featureContext->getResponseContent(true);

        $this->featureContext->request(
            Request::METHOD_POST,
            '/api/auth/refresh',
            [
                'refreshToken' => $response['refreshToken'],
            ],
            server: [
                'HTTP_AUTHORIZATION' => 'Bearer '.$response['token'],
            ]
        );
    }

    #[Given('/^I fetch my data$/')]
    public function fetchMyData(): void
    {
        $this->featureContext->request(Request::METHOD_GET, '/api/users/me');
    }
}
