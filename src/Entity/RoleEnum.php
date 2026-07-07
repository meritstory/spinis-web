<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\EnumFromNameTrait;

enum RoleEnum: string
{
    use EnumFromNameTrait;

    case USER = 'ROLE_USER';
    case ADMIN = 'ROLE_ADMIN';
}
