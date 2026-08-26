<?php

declare(strict_types=1);

namespace App\Admin\Action;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Action\ActionsExtensionInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\ActionDto;
use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class IconOnlyRowActionsExtension implements ActionsExtensionInterface
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    /** @param AdminContext<object> $context */
    public function supports(AdminContext $context): bool
    {
        return true;
    }

    /** @param AdminContext<object> $context */
    public function extend(Actions $actions, AdminContext $context): void
    {
        foreach ($actions->getAsDto(Crud::PAGE_INDEX)->getActions() as $actionDto) {
            if (!$actionDto instanceof ActionDto || !$actionDto->isEntityAction() || $actionDto->getIcon() === null) {
                continue;
            }

            $label = $actionDto->getLabel();
            if (false === $label) {
                continue;
            }

            if (!$label instanceof TranslatableInterface && (!is_string($label) || $label === '')) {
                continue;
            }

            $tooltip = $label instanceof TranslatableInterface
                ? $label->trans($this->translator)
                : $this->translator->trans($label);

            $actions->update(Crud::PAGE_INDEX, $actionDto->getName(), fn (Action $action): Action => $action
                ->setLabel(false)
                ->asTextLink()
                ->setHtmlAttributes([...$actionDto->getHtmlAttributes(), 'title' => $tooltip])
            );
        }
    }
}
