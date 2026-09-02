<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

/**
 * @template TEntity of object
 *
 * @extends AbstractCrudController<TEntity>
 */
abstract class AbstractAdminCrudController extends AbstractCrudController
{
    protected function getFlashEntityKey(): ?string
    {
        return null;
    }

    protected function getFlashMessage(string $action): string
    {
        $entityKey = $this->getFlashEntityKey();
        if ($entityKey !== null) {
            return sprintf('crud.flash.%s.%s', $entityKey, $action);
        }

        return sprintf('crud.flash.%s', $action);
    }

    public function persistEntity(EntityManagerInterface $entityManager, object $entityInstance): void
    {
        parent::persistEntity($entityManager, $entityInstance);
        $this->addFlash('success', $this->getFlashMessage('created'));
    }

    public function updateEntity(EntityManagerInterface $entityManager, object $entityInstance): void
    {
        parent::updateEntity($entityManager, $entityInstance);
        $this->addFlash('success', $this->getFlashMessage('updated'));
    }

    public function deleteEntity(EntityManagerInterface $entityManager, object $entityInstance): void
    {
        parent::deleteEntity($entityManager, $entityInstance);
        $this->addFlash('success', $this->getFlashMessage('deleted'));
    }
}
