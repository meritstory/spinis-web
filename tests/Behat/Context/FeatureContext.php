<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use App\Tests\Service\Sylius\SharedStorageInterface;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Webmozart\Assert\Assert;

final class FeatureContext extends RawMinkContext implements Context
{
    public const string SS_RESPONSE_CONTENT = self::class.':responseContent';
    public const string SS_BASIC_AUTH = self::class.':basicAuth';

    public function __construct(
        private readonly SharedStorageInterface $sharedStorage,
    ) {
    }

    #[Given('/^I submit the request$/')]
    public function iSubmitTheRequest(): void
    {
        $request = $this->sharedStorage->get('request');

        $this->request(
            $request['method'],
            $request['url'],
            $request['data'] ?? [],
            $request['content'] ?? null,
            $request['server'] ?? [],
            $request['files'] ?? [],
            null,
        );
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
        if (!array_key_exists('HTTP_AUTHORIZATION', $server)) {
            if ($this->sharedStorage->has(self::SS_BASIC_AUTH)) {
                $token = \base64_encode((string) $this->sharedStorage->get(self::SS_BASIC_AUTH));
                $server['HTTP_AUTHORIZATION'] = "Basic $token";
            } elseif ($this->sharedStorage->has(UserContext::SS_AUTH_TOKEN)) {
                $token = $this->sharedStorage->get(UserContext::SS_AUTH_TOKEN);
                $server['HTTP_AUTHORIZATION'] = "Bearer $token";
            } else {
                $server['HTTP_AUTHORIZATION'] = null;
            }
        }

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

        $this->sharedStorage->set(self::SS_RESPONSE_CONTENT, $responseContent);
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

    #[Given('/^fetched data should look like:$/')]
    public function fetchedDataShouldLookLike(?TableNode $table = null): void
    {
        self::validateValueAgainstTable($this->getResponseData(), $table);
    }

    #[Given('/^fetched data list should not include items:$/')]
    public function fetchedDataListShouldNotIncludeItems(TableNode $table): void
    {
        $dataList = $this->getResponseData();

        foreach ($table as $row) {
            foreach ($dataList as $data) {
                $intersection = \array_intersect_assoc($data, $row);

                if (\count($intersection) === \count($row)) {
                    throw new \InvalidArgumentException(\sprintf('List should not contain item %s', \json_encode($row)));
                }
            }
        }
    }

    #[Given('/^fetched response array should look like:$/')]
    public function fetchedResponseArrayShouldLookLike(?TableNode $table = null): void
    {
        self::validateValueAgainstTable($this->getResponseContent(true), $table);
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

    /** @BeforeScenario */
    #[Given('/^session is restarted$/')]
    public function sessionIsRestarted(): void
    {
        $this->getSession()->restart();
    }

    #[Given('/^I get validation errors on "([^"]*)"$/')]
    public function iGetValidationErrorsOn(string $properties): void
    {
        $properties = \explode(',', \strtr($properties, [' ' => '']));
        $content = $this->getResponseContent(true);
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        foreach ($properties as $property) {
            $errorPath = $property === 'errors'
                ? '[errors][errors]'
                : '[errors][children]['.\strtr($property, ['.' => '][']).'][errors]';

            $error = $propertyAccessor->getValue($content, $errorPath);
            Assert::notNull($error, \sprintf('Field [%s] has no errors', $property));
        }
    }

    #[Given('/^I get validation errors on "([^"]*)" matching "([^"]*)"$/')]
    public function iGetValidationErrorsOnMatching(string $properties, string $matching): void
    {
        $properties = \explode(',', strtr($properties, [' ' => '']));
        $content = $this->getResponseContent(true);
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        foreach ($properties as $property) {
            $errorPath = $property === 'errors'
                ? '[errors][errors]'
                : '[errors][children]['.strtr($property, ['.' => '][']).'][errors]';

            $error = $propertyAccessor->getValue($content, $errorPath);
            Assert::notNull($error, \sprintf('Field [%s] has no errors', $property));
            Assert::eq(
                $error[0],
                $matching,
                \sprintf(
                    'Field [%s] has incorrect error code [%s], expected [%s]',
                    $property,
                    $error[0],
                    $matching
                )
            );
        }
    }

    #[Given('/^I get validation error "([^"]*)"$/')]
    public function iGetValidationError(string $expectedError): void
    {
        $content = $this->getResponseContent(true);
        $actualErrors = $content['errors']['errors'] ?? [];

        foreach ($actualErrors as $error) {
            if ($expectedError === $error) {
                return;
            }
        }

        Assert::true(
            false,
            \sprintf('Can\'t find error [%s] in errors response [%s]', $expectedError, \json_encode($content['errors']))
        );
    }

    #[Given('/^the response should contain:$/')]
    public function theResponseShouldContain(TableNode $table): void
    {
        $response = $this->getResponseContent(true);

        foreach ($table->getRowsHash() as $key => $expected) {
            Assert::keyExists($response, $key);

            match ($expected) {
                'STRING' => Assert::stringNotEmpty($response[$key]),
                default => Assert::eq($response[$key], $expected),
            };
        }
    }

    public static function getPropertyAccessor(): PropertyAccessor|PropertyAccessorInterface
    {
        return PropertyAccess::createPropertyAccessorBuilder()
            ->enableExceptionOnInvalidPropertyPath()
            ->getPropertyAccessor()
        ;
    }

    #[Given('/^I create "(GET|POST|PUT|PATCH|DELETE)" request to "([^"]*)" with (query|data|body|json):$/')]
    public function iCreateRequestToWith(string $method, string $url, string $type, TableNode|PyStringNode $data): void
    {
        $request = [
            'method' => $method,
            'url' => $url,
            'server' => [],
        ];

        switch ($type) {
            case 'query':
                $request['data'] = $data->getRowsHash();
                break;
            case 'data':
                $request['data'] = $data->getRowsHash();
                $request['server']['HTTP_Content-Type'] = 'multipart/form-data';
                break;
            case 'body':
                $request['content'] = $data->getRowsHash();
                break;
            case 'json':
                $request['content'] = $data->getRaw();
                break;
        }

        $this->sharedStorage->set('request', $request);
    }

    /**
     * @param mixed[]|object $values
     * @param mixed[]        $expectedValues
     */
    public static function validateValues(object|array $values, array $expectedValues): void
    {
        $propertyAccessor = FeatureContext::getPropertyAccessor();

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
