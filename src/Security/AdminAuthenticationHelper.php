<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Admin;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\HttpFoundation\Response;

final readonly class AdminAuthenticationHelper
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function authenticateAfterPasswordSetup(Admin $admin): ?Response
    {
        if ($admin->isDeleted() || !$admin->isActive()) {
            throw new CustomUserMessageAccountStatusException('login.error.invalid_credentials');
        }

        return $this->security->login($admin, 'form_login', 'admin');
    }
}
