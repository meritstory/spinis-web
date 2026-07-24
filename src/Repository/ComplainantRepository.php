<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Complainant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Complainant>
 *
 * @method Complainant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Complainant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Complainant|null findOneByPersonalCode(string $personalCode)
 * @method Complainant[]    findAll()
 * @method Complainant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComplainantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Complainant::class);
    }
}
