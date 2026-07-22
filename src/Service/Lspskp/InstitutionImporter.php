<?php

declare(strict_types=1);

namespace App\Service\Lspskp;

use App\Entity\HealthCareInstitution;
use App\Repository\HealthCareInstitutionRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

use function count;

class InstitutionImporter
{
    private const int PAGE_SIZE = 100;
    private const string OVERLAP = '-5 minutes';
    private const string DEFAULT_SINCE = '1900-01-01T00:00:00+00:00';

    public function __construct(
        private readonly LspskpClient $client,
        private readonly HealthCareInstitutionRepository $institutions,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function import(): void
    {
        $from = $this->resolveLastUpdatedAt()->modify(self::OVERLAP);
        $offset = 0;

        do {
            $page = $this->client->fetchInstitutions($from, self::PAGE_SIZE, $offset);
            $items = $page['items'];

            foreach ($items as $item) {
                $this->upsert($item);
            }

            $this->entityManager->flush();
            $this->entityManager->clear();

            $offset += self::PAGE_SIZE;
        } while (count($items) === self::PAGE_SIZE);
    }

    /**
     * @param array<string, mixed> $item
     */
    private function upsert(array $item): void
    {
        $code = (int) $item['code'];
        $institution = $this->institutions->findOneBy(['code' => $code]);

        if ($institution === null) {
            $institution = new HealthCareInstitution();
            $this->entityManager->persist($institution);
        }

        $institution
            ->setTitle($item['title'])
            ->setCode($code)
            ->setLicensed(true);
    }

    private function resolveLastUpdatedAt(): DateTimeImmutable
    {
        return $this->institutions->findLatestUpdatedAt() ?? new DateTimeImmutable(self::DEFAULT_SINCE);
    }
}
