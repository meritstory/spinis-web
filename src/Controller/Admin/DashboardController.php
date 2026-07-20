<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Service\Admin\AdminHomeRouteResolver;
use App\Service\Admin\AdminMenuRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly AdminHomeRouteResolver $homeRouteResolver,
    ) {
    }

    public function index(): Response
    {
        $user = $this->getUser();

        if ($user instanceof Admin) {
            return $this->redirectToRoute($this->homeRouteResolver->resolve($user));
        }

        return $this->redirectToRoute('admin_admin_index');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle($this->translator->trans('app.name'))
            ->setTranslationDomain('messages');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addCssFile('styles/admin-forms.css');
    }

    public function configureMenuItems(): iterable
    {
        foreach (AdminMenuRegistry::items() as $menuItem) {
            $item = MenuItem::linkTo($menuItem['controller'], $menuItem['label'], $menuItem['icon']);

            if ($menuItem['role'] !== null) {
                $item->setPermission($menuItem['role']);
            }

            yield $item;
        }
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        if (!$user instanceof Admin) {
            return parent::configureUserMenu($user);
        }

        return parent::configureUserMenu($user)->setName($user->getDisplayName());
    }
}
