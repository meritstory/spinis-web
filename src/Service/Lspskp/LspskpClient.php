<?php

declare(strict_types=1);

namespace App\Service\Lspskp;

use DateTimeInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LspskpClient
{
    private const string ENDPOINT = '/api/external/health-care-institutions';

    public function __construct(
        private readonly HttpClientInterface $lspskpClient,
    ) {
    }

    /**
     * @return array{count: int, items: list<array{code: int, title: string}>}
     */
    public function fetchInstitutions(DateTimeInterface $dateTimeFrom, int $limit, int $offset): array
    {
        $response = $this->lspskpClient->request('GET', self::ENDPOINT, [
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
