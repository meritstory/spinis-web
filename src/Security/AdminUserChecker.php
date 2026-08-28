<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Admin;
use App\Service\Admin\AdminInvitationService;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class AdminUserChecker implements UserCheckerInterface
{
    public function __construct(
        private AdminInvitationService $invitationService,
    ) {
    }

    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof Admin) {
            return;
        }

        if ($this->invitationService->hasUnusablePassword($user)) {
            throw new CustomUserMessageAccountStatusException('login.error.invalid_credentials');
        }
    }

    public function checkPostAuth(UserInterface $user, ?TokenInterface $token = null): void
    {
        if (!$user instanceof Admin) {
            return;
        }

        if ($user->isDeleted()) {
            throw new CustomUserMessageAccountStatusException('login.error.invalid_credentials');
        }

        if (!$user->isActive()) {
            throw new CustomUserMessageAccountStatusException('login.error.account_deactivated');
        }
    }
}
