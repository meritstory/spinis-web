<?php

declare(strict_types=1);

namespace App\Service;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class PageSizeService
{
    /** @var list<int> */
    public const array PAGE_SIZES = [10, 20, 50];

    public const int DEFAULT_PAGE_SIZE = 10;

    private const string SESSION_KEY_PREFIX = 'ea_list_state.';
    private const string PAGE_SIZE_ATTRIBUTE = 'pageSize';
    private const string PAGE_SIZES_ATTRIBUTE = 'pageSizes';

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function configureCrud(Crud $crud): Crud
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request === null) {
            return $crud->setPaginatorPageSize(self::DEFAULT_PAGE_SIZE);
        }

        $configuredPageSize = $request->attributes->get(self::PAGE_SIZE_ATTRIBUTE);
        if (is_int($configuredPageSize)) {
            return $crud->setPaginatorPageSize($configuredPageSize);
        }

        if ($request->attributes->get(EA::CRUD_ACTION) === Action::INDEX) {
            $this->restoreIndexQueryState($request);
        }

        $pageSize = $this->resolvePageSize($request);

        $request->attributes->set(self::PAGE_SIZE_ATTRIBUTE, $pageSize);
        $request->attributes->set(self::PAGE_SIZES_ATTRIBUTE, self::PAGE_SIZES);

        $this->persistIndexQueryState($request, $pageSize);

        return $crud->setPaginatorPageSize($pageSize);
    }

    private function restoreIndexQueryState(Request $request): void
    {
        $session = $request->getSession();
        $state = $session->get($this->sessionKey($request));
        if (!is_array($state)) {
            return;
        }

        if (!$request->query->has('pageSize') && isset($state['pageSize'])) {
            $request->query->set('pageSize', $state['pageSize']);
        }

        if (!$request->query->has('page') && isset($state['page'])) {
            $request->query->set('page', $state['page']);
        }
    }

    private function resolvePageSize(Request $request): int
    {
        if ($request->query->has('pageSize')) {
            $pageSize = $request->query->getInt('pageSize');

            if (in_array($pageSize, self::PAGE_SIZES, true)) {
                return $pageSize;
            }

            $this->flashInvalidPageSize($request);

            return self::DEFAULT_PAGE_SIZE;
        }

        $session = $request->getSession();
        $state = $session->get($this->sessionKey($request));
        if (is_array($state) && isset($state['pageSize']) && in_array($state['pageSize'], self::PAGE_SIZES, true)) {
            return $state['pageSize'];
        }

        return self::DEFAULT_PAGE_SIZE;
    }

    private function flashInvalidPageSize(Request $request): void
    {
        if (!$request->hasSession()) {
            return;
        }

        $session = $request->getSession();
        if (!$session instanceof FlashBagAwareSessionInterface) {
            return;
        }

        $session->getFlashBag()->add(
            'warning',
            $this->translator->trans('paginator.invalid_page_size', ['%default%' => self::DEFAULT_PAGE_SIZE]),
        );
    }

    private function persistIndexQueryState(Request $request, int $pageSize): void
    {
        if ($request->attributes->get(EA::CRUD_ACTION) !== Action::INDEX) {
            return;
        }

        $session = $request->getSession();

        $session->set($this->sessionKey($request), [
            'pageSize' => $pageSize,
            'page' => max(1, $request->query->getInt('page', 1)),
        ]);
    }

    private function sessionKey(Request $request): string
    {
        $controllerFqcn = $request->attributes->get(EA::CRUD_CONTROLLER_FQCN, '');

        return self::SESSION_KEY_PREFIX.$controllerFqcn;
    }
}
