<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Entity\Admin;
use App\Entity\RoleEnum;

final class AdminHomeRouteResolver
{
    public function resolve(Admin $admin): string
    {
        $roles = $admin->getRoles();

        foreach ([RoleEnum::SYSTEM_ADMIN->value, RoleEnum::DEPARTMENT_HEAD->value] as $role) {
            if (!in_array($role, $roles, true)) {
                continue;
            }

            foreach (AdminMenuRegistry::items() as $menuItem) {
                if ($menuItem['role'] === $role) {
                    return $menuItem['route'];
                }
            }
        }

        return AdminMenuRegistry::defaultRoute();
    }
}
