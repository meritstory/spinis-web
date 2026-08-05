<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ComplaintPatient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ComplaintPatient>
 */
class ComplaintPatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplaintPatient::class);
    }
}
