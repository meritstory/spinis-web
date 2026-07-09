<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Entity\Admin;
use App\Entity\RoleEnum;

final class AdminHomeRouteResolver
{
    private const array HOME_ROUTES_BY_ROLE = [
        RoleEnum::ADMIN->value => 'admin_admin_index',
    ];

    private const string DEFAULT_ROUTE = 'admin_admin_index';

    public function resolve(Admin $admin): string
    {
        foreach ($admin->getRoles() as $role) {
            if (isset(self::HOME_ROUTES_BY_ROLE[$role])) {
                return self::HOME_ROUTES_BY_ROLE[$role];
            }
        }

        return self::DEFAULT_ROUTE;
    }
}
