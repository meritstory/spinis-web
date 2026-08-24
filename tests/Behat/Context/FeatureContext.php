<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Webmozart\Assert\Assert;

final class FeatureContext extends RawMinkContext implements Context
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param mixed[] $parameters
     * @param mixed[]|string|null $content
     * @param mixed[] $server
     * @param mixed[] $files
     */
    public function request(
        string $method,
        string $url,
        array $parameters = [],
        array|string|null $content = null,
        array $server = [],
        array $files = [],
        ?int $expectStatusCode = Response::HTTP_OK,
    ): void {
        if (\is_array($content)) {
            $content = \json_encode($content);
        }

        if (null !== $content && !is_string($content)) {
            throw new \InvalidArgumentException('Invalid type for $content argument');
        }

        $this->getSession()->getDriver()->getClient()->request(
            $method,
            $url,
            $parameters,
            $files,
            $server,
            $content
        );

        $statusCode = $this->getSession()->getStatusCode();
        $responseContent = $this->getSession()->getPage()->getContent();

        if (null !== $expectStatusCode) {
            Assert::eq(
                $statusCode,
                $expectStatusCode,
                strtr(
                    \sprintf(
                        'Response for url [%s] has returned wrong status code [%s] instead of [%s]. Response text [%s]',
                        $url,
                        $statusCode,
                        $expectStatusCode,
                        $responseContent
                    ),
                    ['%' => '%%']
                )
            );
        }
    }

    #[Given('/^I visit "([^"]*)"$/')]
    public function iVisit(string $url): void
    {
        $this->request(Request::METHOD_GET, $url);
    }

    #[Given('/^entity manager is cleared$/')]
    public function entityManagerIsCleared(): void
    {
        $this->entityManager->clear();
    }

    /** @BeforeScenario */
    #[Given('/^session is restarted$/')]
    public function sessionIsRestarted(): void
    {
        $this->getSession()->restart();
    }

    public static function getPropertyAccessor(): PropertyAccessor|PropertyAccessorInterface
    {
        return PropertyAccess::createPropertyAccessorBuilder()
            ->enableExceptionOnInvalidPropertyPath()
            ->getPropertyAccessor()
        ;
    }
}
