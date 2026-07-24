<?php

declare(strict_types=1);

namespace App\Service\Lspskp;

use DateTimeInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LspskpClient
{
    private const string ENDPOINT = '/api/external/health-care-institutions';

    public function __construct(
        #[Autowire(service: 'lspskp.client')]
        private readonly HttpClientInterface $client,
    ) {
    }

    /**
     * @return array{count: int, items: list<array{code: int, title: string}>}
     */
    public function fetchInstitutions(DateTimeInterface $dateTimeFrom, int $limit, int $offset): array
    {
        $response = $this->client->request('GET', self::ENDPOINT, [
            'query' => [
                'dateTimeFrom' => $dateTimeFrom->format(DateTimeInterface::ATOM),
                'limit' => $limit,
                'offset' => $offset,
            ],
        ]);

        /** @var array{count: int, items: list<array{code: int, title: string}>} */
        return $response->toArray();
    }
}
