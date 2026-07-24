<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\EnumFromNameTrait;

enum RoleEnum: string
{
    use EnumFromNameTrait;

    case USER = 'ROLE_USER';
    case COMPLAINANT = 'ROLE_COMPLAINANT';
    case DEPARTMENT_HEAD = 'ROLE_DEPARTMENT_HEAD';
    case SPECIALIST = 'ROLE_SPECIALIST';
    case INSTITUTION_ADMIN = 'ROLE_INSTITUTION_ADMIN';
    case COMMISSION_MEMBER = 'ROLE_COMMISSION_MEMBER';
    case EXPERT = 'ROLE_EXPERT';
    case SYSTEM_ADMIN = 'ROLE_SYSTEM_ADMIN';

    /**
     * @return list<self>
     */
    public static function adminPanelRoles(): array
    {
        return [
            self::DEPARTMENT_HEAD,
            self::SPECIALIST,
            self::INSTITUTION_ADMIN,
            self::COMMISSION_MEMBER,
            self::EXPERT,
            self::SYSTEM_ADMIN,
        ];
    }

    /**
     * @return list<string>
     */
    public static function adminPanelRoleValues(): array
    {
        return array_map(static fn (self $role): string => $role->value, self::adminPanelRoles());
    }

    public function getLabelKey(): string
    {
        return match ($this) {
            self::USER => 'admin.role.user',
            self::COMPLAINANT => 'admin.role.complainant',
            self::DEPARTMENT_HEAD => 'admin.role.department_head',
            self::SPECIALIST => 'admin.role.specialist',
            self::INSTITUTION_ADMIN => 'admin.role.institution_admin',
            self::COMMISSION_MEMBER => 'admin.role.commission_member',
            self::EXPERT => 'admin.role.expert',
            self::SYSTEM_ADMIN => 'admin.role.system_admin',
        };
    }

    public static function tryFromAdminRole(?string $role): ?self
    {
        if ($role === null || $role === '' || $role === self::USER->value) {
            return null;
        }

        return self::tryFrom($role);
    }
}
