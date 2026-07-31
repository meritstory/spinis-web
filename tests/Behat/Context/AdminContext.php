<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use App\Entity\Admin;
use App\Entity\RoleEnum;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminContext extends RawMinkContext implements Context
{
    public const string ADMIN_DEFAULT_PASSWORD = 'test';

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Given('/^(admin|specialist|department_head) with email "([^"]*)" is created$/')]
    #[Given('/^(admin|specialist|department_head) with email "([^"]*)" and password "([^"]*)" is created$/')]
    public function adminIsCreated(
        string $role,
        string $email,
        string $password = self::ADMIN_DEFAULT_PASSWORD,
    ): void {
        $this->createAdmin($role, $email, $password, false);
    }

    #[Given('/^(admin|specialist|department_head) with email "([^"]*)" is created without two-factor$/')]
    #[Given('/^(admin|specialist|department_head) with email "([^"]*)" and password "([^"]*)" is created without two-factor$/')]
    public function adminIsCreatedWithoutTwoFactor(
        string $role,
        string $email,
        string $password = self::ADMIN_DEFAULT_PASSWORD,
    ): void {
        $this->createAdmin($role, $email, $password, true);
    }

    private function createAdmin(string $role, string $email, string $password, bool $withoutTwoFactor): void
    {
        $roleEnum = match (strtolower($role)) {
            'admin' => RoleEnum::SYSTEM_ADMIN,
            'specialist' => RoleEnum::SPECIALIST,
            'department_head' => RoleEnum::DEPARTMENT_HEAD,
            default => RoleEnum::fromName(strtoupper($role)),
        };

        $localPart = strstr($email, '@', true) ?: 'test';

        $admin = new Admin()
            ->setEmail($email)
            ->setFirstName(ucfirst($localPart))
            ->setLastName('Test')
            ->setRoles([$roleEnum->value])
            ->setActive(true)
            ->setEmailTwoFactorEnabled(!$withoutTwoFactor);

        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, $password));

        $this->entityManager->persist($admin);
        $this->entityManager->flush();
    }

    #[Given('/^inactive admin with email "([^"]*)" and password "([^"]*)" is created$/')]
    public function inactiveAdminIsCreated(string $email, string $password): void
    {
        $localPart = strstr($email, '@', true) ?: 'test';

        $admin = new Admin()
            ->setEmail($email)
            ->setFirstName(ucfirst($localPart))
            ->setLastName('Test')
            ->setRoles([RoleEnum::SYSTEM_ADMIN->value])
            ->setActive(false);

        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, $password));

        $this->entityManager->persist($admin);
        $this->entityManager->flush();
    }
}
