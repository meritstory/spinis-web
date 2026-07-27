<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Entity\Admin;

final class AdminHomeRouteResolver
{
    public function resolve(Admin $admin): string
    {
        $roles = $admin->getRoles();

        foreach (AdminMenuRegistry::items() as $menuItem) {
            if ($menuItem['role'] === null || in_array($menuItem['role'], $roles, true)) {
                return $menuItem['route'];
            }
        }

        return AdminMenuRegistry::defaultRoute();
    }
}
