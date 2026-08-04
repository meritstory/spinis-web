<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ComplaintAttachment;
use App\Entity\StoredFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ComplaintAttachment>
 */
class ComplaintAttachmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplaintAttachment::class);
    }

    public function existsForStoredFile(StoredFile $storedFile): bool
    {
        return $this->count(['storedFile' => $storedFile]) > 0;
    }
}
