<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Setting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Setting>
 */
class SettingRepository extends ServiceEntityRepository
{
    private const string EMPTY_VALUE = '';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Setting::class);
    }

    /** @return array<string> */
    public function findUsedKeys(): array
    {
        $keys = $this->createQueryBuilder('setting')
            ->select('setting.key')
            ->andWhere($this->getCompletedValueDql('setting'))
            ->setParameter('emptyValue', self::EMPTY_VALUE)
            ->getQuery()
            ->getSingleColumnResult();

        return array_values(array_map(static fn (mixed $key): string => (string) $key, $keys));
    }

    public function findDraftByKey(string $key): ?Setting
    {
        return $this->createQueryBuilder('setting')
            ->andWhere('setting.key = :key')
            ->andWhere($this->getEmptyValueDql('setting'))
            ->setParameter('key', $key)
            ->setParameter('emptyValue', self::EMPTY_VALUE)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param array{key?: string} $criteria
     *
     * @return array<Setting>
     */
    public function findCompletedByKey(array $criteria): array
    {
        $key = $criteria['key'] ?? '';

        if ($key === '') {
            return [];
        }

        return $this->createQueryBuilder('setting')
            ->andWhere('setting.key = :key')
            ->andWhere($this->getCompletedValueDql('setting'))
            ->setParameter('key', $key)
            ->setParameter('emptyValue', self::EMPTY_VALUE)
            ->getQuery()
            ->getResult();
    }

    public function getCompletedValueDql(string $alias): string
    {
        return sprintf('TRIM(%s.value) != :emptyValue', $alias);
    }

    private function getEmptyValueDql(string $alias): string
    {
        return sprintf('TRIM(%s.value) = :emptyValue', $alias);
    }
}
