<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use App\Entity\RoleEnum;
use App\Entity\User;
use App\Tests\Service\Sylius\SharedStorageInterface;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\Token\JWTPostAuthenticationToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserContext extends RawMinkContext implements Context
{
    public const string SS_AUTH_TOKEN = __CLASS__.':authToken';
    public const string SS_CURRENT_USER = __CLASS__.':currentUser';
    public const string USER_DEFAULT_PASSWORD = 'test';

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityManagerInterface $entityManager,
        private readonly JWTTokenManagerInterface $tokenManager,
        private readonly TokenStorageInterface $tokenStorage,
        private readonly SharedStorageInterface $sharedStorage,
    ) {
    }

    #[Given('/^(user) with username "([^"]*)" is created$/')]
    #[Given('/^(user) with username "([^"]*)" and password "([^"]*)" is created$/')]
    public function userIsCreated(
        string $role,
        string $username,
        string $password = self::USER_DEFAULT_PASSWORD
    ): void {
        $roleEnum = RoleEnum::fromName(strtoupper($role));

        $user = (new User())
            ->setUsername($username)
            ->setRoles([$roleEnum->value])
        ;

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    #[Given('/^(user with username "[^"]*") is authenticated$/')]
    public function userIsAuthenticated(User $user): void
    {
        $this->sharedStorage->set(FeatureContext::SS_BASIC_AUTH, null);

        $token = $this->tokenManager->create($user);

        $this->tokenStorage->setToken(new JWTPostAuthenticationToken($user, 'api', $user->getRoles(), $token));
        $this->sharedStorage->set(self::SS_AUTH_TOKEN, $token);

        $this->getSession()->setRequestHeader('Authorization', "Bearer {$token}");
        $this->sharedStorage->set(self::SS_CURRENT_USER, $user);
    }
}
