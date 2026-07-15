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
     * @Transform /^admin(?:| with email) "([^"]*)"$/
     * @Transform /^"([^"]*)" admin$/
     * @Transform /^admin "([^"]*)"$/
     */
    public function transformAdminByEmail(string $email): Admin
    {
        $admin = $this->adminRepository->findOneByEmail($email);

        Assert::notNull($admin, sprintf('Admin by email "%s" does not exist', $email));

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
