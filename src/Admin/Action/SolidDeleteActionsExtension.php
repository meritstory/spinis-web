<?php

declare(strict_types=1);

namespace App\Admin\Action;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Action\ActionsExtensionInterface;
use EasyCorp\Bundle\EasyAdminBundle\Twig\Component\Option\ButtonStyle;

final readonly class SolidDeleteActionsExtension implements ActionsExtensionInterface
{
    /** @param AdminContext<object> $context */
    public function supports(AdminContext $context): bool
    {
        return true;
    }

    /** @param AdminContext<object> $context */
    public function extend(Actions $actions, AdminContext $context): void
    {
        foreach ([Crud::PAGE_DETAIL, Crud::PAGE_EDIT] as $pageName) {
            if (null === $actions->getAsDto($pageName)->getAction($pageName, Action::DELETE)) {
                continue;
            }

            $actions->update($pageName, Action::DELETE, static function (Action $action): Action {
                $action->getAsDto()->setStyle(ButtonStyle::Solid);

                return $action;
            });
        }
    }
}
