<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Controller\Admin\AdminCrudController;
use App\Controller\Admin\DocumentCrudController;
use App\Controller\Admin\FaqCrudController;
use App\Controller\Admin\LinkCrudController;
use App\Controller\Admin\SettingCrudController;
use App\Entity\RoleEnum;

final class AdminMenuRegistry
{
    private const array ITEMS = [
        [
            'controller' => AdminCrudController::class,
            'route' => 'admin_admin_index',
            'label' => 'menu.admins',
            'icon' => 'fa fa-users',
            'role' => RoleEnum::SYSTEM_ADMIN->value,
        ],
        [
            'controller' => FaqCrudController::class,
            'route' => 'admin_faq_index',
            'label' => 'menu.faq',
            'icon' => 'fa fa-question-circle',
            'role' => null,
        ],
        [
            'controller' => DocumentCrudController::class,
            'route' => 'admin_document_index',
            'label' => 'menu.documents',
            'icon' => 'fa fa-file-text',
            'role' => null,
        ],
        [
            'controller' => LinkCrudController::class,
            'route' => 'admin_link_index',
            'label' => 'menu.links',
            'icon' => 'fa fa-link',
            'role' => null,
        ],
        [
            'controller' => SettingCrudController::class,
            'route' => 'admin_setting_index',
            'label' => 'menu.settings',
            'icon' => 'fa fa-cog',
            'role' => null,
        ],
    ];

    /**
     * @return list<array{
     *     controller: class-string,
     *     route: string,
     *     label: string,
     *     icon: string,
     *     role: ?string,
     * }>
     */
    public static function items(): array
    {
        return self::ITEMS;
    }

    public static function defaultRoute(): string
    {
        foreach (self::ITEMS as $item) {
            if ($item['role'] === null) {
                return $item['route'];
            }
        }

        return 'admin_faq_index';
    }
}
