<?php

declare(strict_types=1);

namespace App\Service\Lspskp;

use App\Entity\HealthCareInstitution;
use App\Entity\HealthCareInstitutionSourceEnum;
use App\Entity\Setting;
use App\Enum\SettingKeyEnum;
use App\Repository\HealthCareInstitutionRepository;
use App\Repository\SettingRepository;
use DateTimeImmutable;
use DateTimeInterface;
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
        private readonly SettingRepository $settings,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function import(): void
    {
        $importStartedAt = new DateTimeImmutable();
        $from = $this->resolveImportFrom()->modify(self::OVERLAP);
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

        $this->updateImportFrom($importStartedAt);
    }

    /**
     * @param array<string, mixed> $item
     */
    private function upsert(array $item): void
    {
        $code = $item['code'];
        $institution = $this->institutions->findOneBy(['code' => $code]);

        if ($institution === null) {
            $institution = new HealthCareInstitution();
            $this->entityManager->persist($institution);
        }

        $institution
            ->setTitle($item['title'])
            ->setCode($code)
            ->setSource(HealthCareInstitutionSourceEnum::LSPSKP);
    }

    private function resolveImportFrom(): DateTimeImmutable
    {
        $setting = $this->settings->findOneBy([
            'key' => SettingKeyEnum::HEALTH_CARE_INSTITUTION_IMPORT_FROM->value,
        ]);

        return new DateTimeImmutable($setting?->getValue() ?: self::DEFAULT_SINCE);
    }

    private function updateImportFrom(DateTimeImmutable $importStartedAt): void
    {
        $setting = $this->settings->findOneBy([
            'key' => SettingKeyEnum::HEALTH_CARE_INSTITUTION_IMPORT_FROM->value,
        ]);

        if ($setting === null) {
            $setting = new Setting()
                ->setKey(SettingKeyEnum::HEALTH_CARE_INSTITUTION_IMPORT_FROM->value);

            $this->entityManager->persist($setting);
        }

        $setting->setValue($importStartedAt->format(DateTimeInterface::ATOM));
        $this->entityManager->flush();
    }
}
