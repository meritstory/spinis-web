<?php

declare(strict_types=1);

namespace App\EventListener;

use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Provider\AdminContextProviderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Exception\EntityNotFoundException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsEventListener(event: KernelEvents::EXCEPTION, priority: 128)]
final readonly class AdminEntityAccessDeniedBeforeNotFoundListener
{
    public function __construct(
        private AdminContextProviderInterface $adminContextProvider,
        private AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        if (!$event->getThrowable() instanceof EntityNotFoundException) {
            return;
        }

        $crudControllerFqcn = $this->adminContextProvider->getContext()?->getCrud()->getControllerFqcn()
            ?? $event->getRequest()->attributes->get(EA::CRUD_CONTROLLER_FQCN);

        if (!is_string($crudControllerFqcn) || $this->isGrantedForCrudController($crudControllerFqcn)) {
            return;
        }

        $event->setThrowable(new AccessDeniedHttpException());
    }

    private function isGrantedForCrudController(string $controllerFqcn): bool
    {
        if (!class_exists($controllerFqcn)) {
            return true;
        }

        foreach (new \ReflectionClass($controllerFqcn)->getAttributes(IsGranted::class) as $attribute) {
            $isGranted = $attribute->newInstance();
            if (!$this->authorizationChecker->isGranted($isGranted->attribute)) {
                return false;
            }
        }

        return true;
    }
}
