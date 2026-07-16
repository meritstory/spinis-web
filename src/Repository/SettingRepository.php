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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Setting::class);
    }

    /**
     * @return list<string>
     */
    public function findUsedKeys(): array
    {
        $keys = $this->createQueryBuilder('setting')
            ->select('setting.key')
            ->getQuery()
            ->getSingleColumnResult();

        return array_values(array_map(static fn (mixed $key): string => (string) $key, $keys));
    }
}
