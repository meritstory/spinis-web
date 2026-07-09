<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use App\Entity\Admin;
use App\Entity\RoleEnum;
use App\Tests\Service\Sylius\SharedStorageInterface;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\Token\JWTPostAuthenticationToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AdminContext extends RawMinkContext implements Context
{
    public const string SS_AUTH_TOKEN = self::class.':authToken';
    public const string SS_CURRENT_ADMIN = self::class.':currentAdmin';
    public const string ADMIN_DEFAULT_PASSWORD = 'test';

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityManagerInterface $entityManager,
        private readonly JWTTokenManagerInterface $tokenManager,
        private readonly TokenStorageInterface $tokenStorage,
        private readonly SharedStorageInterface $sharedStorage,
    ) {
    }

    #[Given('/^(admin) with username "([^"]*)" is created$/')]
    #[Given('/^(admin) with username "([^"]*)" and password "([^"]*)" is created$/')]
    public function adminIsCreated(
        string $role,
        string $email,
        string $password = self::ADMIN_DEFAULT_PASSWORD
    ): void {
        $roleEnum = RoleEnum::fromName(strtoupper($role));

        $admin = (new Admin())
            ->setEmail($email)
            ->setRoles([$roleEnum->value])
            ->setActive(true);

        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, $password));

        $this->entityManager->persist($admin);
        $this->entityManager->flush();
    }

    #[Given('/^inactive admin with username "([^"]*)" and password "([^"]*)" is created$/')]
    public function inactiveAdminIsCreated(string $email, string $password): void
    {
        $admin = (new Admin())
            ->setEmail($email)
            ->setRoles([RoleEnum::ADMIN->value])
            ->setActive(false);

        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, $password));

        $this->entityManager->persist($admin);
        $this->entityManager->flush();
    }

    #[Given('/^(admin with username "[^"]*") is authenticated$/')]
    public function adminIsAuthenticated(Admin $admin): void
    {
        $this->sharedStorage->set(FeatureContext::SS_BASIC_AUTH, null);

        $token = $this->tokenManager->create($admin);

        $this->tokenStorage->setToken(new JWTPostAuthenticationToken($admin, 'api', $admin->getRoles(), $token));
        $this->sharedStorage->set(self::SS_AUTH_TOKEN, $token);

        $this->getSession()->setRequestHeader('Authorization', "Bearer {$token}");
        $this->sharedStorage->set(self::SS_CURRENT_ADMIN, $admin);
    }
}
