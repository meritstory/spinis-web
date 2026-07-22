<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Document>
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    /** @return array<string> */
    public function findUsedKeys(): array
    {
        $keys = $this->createQueryBuilder('document')
            ->select('document.key')
            ->getQuery()
            ->getSingleColumnResult();

        return array_values(array_map(static fn (mixed $key): string => (string) $key, $keys));
    }
}
