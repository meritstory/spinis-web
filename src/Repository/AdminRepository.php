<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Admin;
use App\Entity\RoleEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
            'deletedAt' => null,
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
        return (int) $this->createQueryBuilder('admin')
            ->select('COUNT(admin.id)')
            ->andWhere('admin.active = true')
            ->andWhere('admin.deletedAt IS NULL')
            ->andWhere('admin.roles = :roles')
            ->setParameter('roles', json_encode([$role->value], JSON_THROW_ON_ERROR))
            ->getQuery()
            ->getSingleScalarResult();
    }
}
