<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Complaint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Complaint>
 */
class ComplaintRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Complaint::class);
    }

    /**
     * @param int[] $specialistIds
     *
     * @return array<int, int>
     */
    public function countAssignedBySpecialistIds(array $specialistIds): array
    {
        if ($specialistIds === []) {
            return [];
        }

        /** @var list<array{specialistId: int, complaintCount: int}> $rows */
        $rows = $this->createQueryBuilder('complaint')
            ->select('IDENTITY(complaint.specialist) AS specialistId', 'COUNT(complaint.id) AS complaintCount')
            ->where('complaint.specialist IN (:specialistIds)')
            ->setParameter('specialistIds', $specialistIds)
            ->groupBy('complaint.specialist')
            ->getQuery()
            ->getArrayResult();

        $counts = [];
        foreach ($rows as $row) {
            $counts[(int) $row['specialistId']] = (int) $row['complaintCount'];
        }

        return $counts;
    }
}
