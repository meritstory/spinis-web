<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
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

    /**
     * @return mixed[]
     */
    public function getResponseHeaders(): array
    {
        return $this->getSession()->getResponseHeaders();
    }

    /**
     * @return string|mixed[]
     */
    public function getResponseContent(bool $asArray = false): string|array
    {
        $response = $this->getSession();
        $content = $response->getPage()->getContent();

        if ($asArray) {
            return \json_decode($content, true);
        }

        return $content;
    }

    /**
     * @return mixed[]
     */
    public function getResponseData(): array
    {
        $content = json_decode($this->getResponseContent(), true);
        Assert::keyExists($content, 'data');

        return $content['data'];
    }

    public function getResponseCode(): int
    {
        return $this->getSession()->getStatusCode();
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

    /**
     * @param mixed[]|object $values
     * @param mixed[]        $expectedValues
     */
    public static function validateValues(object|array $values, array $expectedValues): void
    {
        $propertyAccessor = self::getPropertyAccessor();

        foreach ($expectedValues as $propertyName => $expectedValue) {
            $prop = is_array($values)
                ? '['.strtr($propertyName, ['.' => '][']).']'
                : $propertyName;
            Assert::eq($propertyAccessor->getValue($values, $prop), $expectedValue);
        }
    }

    public static function validateValueAgainstTable(object|array|null $value, ?TableNode $table = null): void
    {
        if (!$table) {
            Assert::null($value);

            return;
        }

        $propertyAccessor = self::getPropertyAccessor();

        foreach ($table as $row) {
            $actual = $propertyAccessor->getValue($value, $row['Property']);

            match (true) {
                'true' === $row['Value'] => Assert::true($actual),
                'false' === $row['Value'] => Assert::false($actual),
                'STRING' === $row['Value'] => Assert::stringNotEmpty($actual),
                \in_array($row['Value'], ['NULL', '~'], true) => Assert::null($actual),
                \str_starts_with((string) $row['Value'], 'REGEX:') => Assert::regex(
                    $actual,
                    \substr((string) $row['Value'], 6)
                ),
                \str_starts_with((string) $row['Value'], 'CONST:') => Assert::eq(
                    $actual,
                    \constant(\substr((string) $row['Value'], 6)),
                ),
                \in_array($row['Value'], ['TODAY', 'YESTERDAY'], true) => Assert::eq(
                    (\is_string($actual) ? new \DateTimeImmutable($actual) : $actual)->format('Y-m-d'),
                    new \DateTimeImmutable($row['Value'])->format('Y-m-d')
                ),
                $actual instanceof \DateTimeInterface => Assert::eq(
                    $actual->format('Y-m-d H:i:s'),
                    new \DateTimeImmutable($row['Value'])->format('Y-m-d H:i:s')
                ),
                $actual instanceof \UnitEnum => Assert::eq($actual->name, $row['Value']),
                default => Assert::eq($actual, $row['Value']),
            };
        }
    }
}
