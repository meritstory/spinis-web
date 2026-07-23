<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HealthCareInstitution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HealthCareInstitution>
 *
 * @method HealthCareInstitution|null find($id, $lockMode = null, $lockVersion = null)
 * @method HealthCareInstitution|null findOneBy(array $criteria, array $orderBy = null)
 * @method HealthCareInstitution[]    findAll()
 * @method HealthCareInstitution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HealthCareInstitutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HealthCareInstitution::class);
    }

}
