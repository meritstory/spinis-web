<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Transform;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\Behat\Context\UserContext as BaseUserContext;
use App\Tests\Service\Sylius\SharedStorageInterface;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final readonly class UserContext implements Context
{
    public function __construct(
        private UserRepository $userRepository,
        private SharedStorageInterface $sharedStorage
    ) {
    }

    /**
     * @Transform /^user(?:| with username) "([^"]*)"$/
     * @Transform /^"([^"]*)" user$/
     * @Transform /^user "([^"]*)"$/
     */
    public function transformUserByEmail(string $username): User
    {
        $user = $this->userRepository->findOneByUsername($username);

        Assert::notNull($user, sprintf('User by username "%s" does not exist', $username));

        return $user;
    }

    /**
     * @Transform /^(I|my|he|his|she|her|"this user")$/
     */
    public function getLoggedUser(): User
    {
        return $this->sharedStorage->get(BaseUserContext::SS_CURRENT_USER);
    }
}
