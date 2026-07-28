<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Transform;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final readonly class AdminContext implements Context
{
    public function __construct(
        private AdminRepository $adminRepository,
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
}
