<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Admin;
use App\Entity\Complaint;
use App\Entity\RoleEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Admin>
 *
 * @method Admin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Admin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Admin|null findOneByAuthCode(string $authCode)
 * @method Admin[]    findAll()
 * @method Admin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Admin::class);
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Admin) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findOneByEmail(string $email): ?Admin
    {
        return $this->findOneBy([
            'email' => mb_strtolower(trim($email)),
        ]);
    }

    /**
     * @param array<string, mixed> $criteria
     */
    public function findOneByEmailForUniqueValidation(array $criteria): ?Admin
    {
        $email = $criteria['email'] ?? null;

        return is_string($email) ? $this->findOneByEmail($email) : null;
    }

    public function countActiveByRole(RoleEnum $role): int
    {
        return (int) $this->applyActiveRoleConstraints(
            $this->createQueryBuilder('admin')->select('COUNT(admin.id)'),
            $role,
            'admin',
        )
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function applyActiveRoleConstraints(QueryBuilder $queryBuilder, RoleEnum $role, string $alias = 'entity'): QueryBuilder
    {
        return $queryBuilder
            ->andWhere(sprintf('%s.active = true', $alias))
            ->andWhere(sprintf('JSONB_CONTAINS(%s.roles, :role) = true', $alias))
            ->setParameter('role', json_encode([$role->value], JSON_THROW_ON_ERROR));
    }

    public function restrictQueryBuilderToActiveSpecialists(
        QueryBuilder $queryBuilder,
        string $alias = 'entity',
        ?int $alsoIncludeAdminId = null,
    ): QueryBuilder {
        $expr = $queryBuilder->expr();
        $isActiveSpecialist = $expr->andX(
            sprintf('%s.active = true', $alias),
            sprintf('JSONB_CONTAINS(%s.roles, :role) = true', $alias),
        );

        if ($alsoIncludeAdminId !== null) {
            $queryBuilder->andWhere($expr->orX(
                $isActiveSpecialist,
                $expr->eq(sprintf('%s.id', $alias), ':alsoIncludeAdminId'),
            ))
                ->setParameter('alsoIncludeAdminId', $alsoIncludeAdminId);
        } else {
            $queryBuilder->andWhere($isActiveSpecialist);
        }

        return $queryBuilder
            ->setParameter('role', json_encode([RoleEnum::SPECIALIST->value], JSON_THROW_ON_ERROR))
            ->orderBy(sprintf('%s.lastName', $alias), 'ASC')
            ->addOrderBy(sprintf('%s.firstName', $alias), 'ASC');
    }

    /**
     * @return array<int, int> specialist admin id => assigned complaint count (includes 0)
     */
    public function mapComplaintAssignmentCountsForActiveSpecialists(): array
    {
        /** @var list<array{adminId: int, complaintCount: int}> $rows */
        $rows = $this->applyActiveRoleConstraints(
            $this->createQueryBuilder('admin')
                ->select('admin.id AS adminId', 'COUNT(complaint.id) AS complaintCount')
                ->leftJoin(Complaint::class, 'complaint', 'WITH', 'complaint.specialist = admin')
                ->groupBy('admin.id'),
            RoleEnum::SPECIALIST,
            'admin',
        )
            ->getQuery()
            ->getArrayResult();

        $counts = [];
        foreach ($rows as $row) {
            $counts[(int) $row['adminId']] = (int) $row['complaintCount'];
        }

        return $counts;
    }

    public function isPersistedActiveSystemAdministrator(Admin $admin): bool
    {
        if ($admin->getId() === null) {
            return $admin->isActive()
                && in_array(RoleEnum::SYSTEM_ADMIN->value, $admin->getRoles(), true);
        }

        return (int) $this->createQueryBuilder('admin')
            ->select('COUNT(admin.id)')
            ->andWhere('admin.id = :id')
            ->andWhere('admin.active = true')
            ->andWhere('JSONB_CONTAINS(admin.roles, :role) = true')
            ->setParameter('id', $admin->getId())
            ->setParameter('role', json_encode([RoleEnum::SYSTEM_ADMIN->value], JSON_THROW_ON_ERROR))
            ->getQuery()
            ->getSingleScalarResult() > 0;
    }
}
