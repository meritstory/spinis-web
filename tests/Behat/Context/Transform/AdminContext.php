<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Transform;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use App\Tests\Behat\Context\AdminContext as BaseAdminContext;
use App\Tests\Service\Sylius\SharedStorageInterface;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final readonly class AdminContext implements Context
{
    public function __construct(
        private AdminRepository $adminRepository,
        private SharedStorageInterface $sharedStorage
    ) {
    }

    /**
     * @Transform /^admin(?:| with username) "([^"]*)"$/
     * @Transform /^"([^"]*)" admin$/
     * @Transform /^admin "([^"]*)"$/
     */
    public function transformAdminByEmail(string $username): Admin
    {
        $admin = $this->adminRepository->findOneByUsername($username);

        Assert::notNull($admin, sprintf('Admin by username "%s" does not exist', $username));

        return $admin;
    }

    /**
     * @Transform /^(I|my|he|his|she|her|"this admin")$/
     */
    public function getLoggedAdmin(): Admin
    {
        return $this->sharedStorage->get(BaseAdminContext::SS_CURRENT_ADMIN);
    }
}
