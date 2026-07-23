<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @implements UserProviderInterface<Admin>
 */
final readonly class AdminUserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    public function __construct(
        private AdminRepository $adminRepository,
    ) {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $admin = $this->adminRepository->findOneByEmail($identifier);

        if ($admin === null) {
            throw new UserNotFoundException(sprintf('Admin with email "%s" was not found.', $identifier));
        }

        return $admin;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof Admin) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return $class === Admin::class || is_subclass_of($class, Admin::class);
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        $this->adminRepository->upgradePassword($user, $newHashedPassword);
    }
}
