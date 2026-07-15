<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Setting;
use App\Enum\SettingKeyEnum;
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

    public function findByKey(SettingKeyEnum $key): ?Setting
    {
        $setting = $this->findOneBy(['key' => $key->value]);

        return $setting instanceof Setting ? $setting : null;
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
