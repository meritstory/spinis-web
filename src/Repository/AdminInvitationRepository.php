<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AdminInvitation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdminInvitation>
 *
 * @method AdminInvitation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminInvitation|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminInvitation[]    findAll()
 * @method AdminInvitation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminInvitationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminInvitation::class);
    }

    public function findOneByTokenHashForUpdate(string $tokenHash): ?AdminInvitation
    {
        /** @var AdminInvitation|null $invitation */
        $invitation = $this->createQueryBuilder('invitation')
            ->andWhere('invitation.tokenHash = :tokenHash')
            ->setParameter('tokenHash', $tokenHash)
            ->getQuery()
            ->setLockMode(LockMode::PESSIMISTIC_WRITE)
            ->getOneOrNullResult();

        return $invitation;
    }
}
