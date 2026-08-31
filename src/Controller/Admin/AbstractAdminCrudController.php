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
    public function persistEntity(EntityManagerInterface $entityManager, object $entityInstance): void
    {
        parent::persistEntity($entityManager, $entityInstance);
        $this->addFlash('success', 'crud.flash.created');
    }

    public function updateEntity(EntityManagerInterface $entityManager, object $entityInstance): void
    {
        parent::updateEntity($entityManager, $entityInstance);
        $this->addFlash('success', 'crud.flash.updated');
    }

    public function deleteEntity(EntityManagerInterface $entityManager, object $entityInstance): void
    {
        parent::deleteEntity($entityManager, $entityInstance);
        $this->addFlash('success', 'crud.flash.deleted');
    }
}
