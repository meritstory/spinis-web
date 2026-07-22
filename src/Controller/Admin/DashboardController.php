<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Service\Admin\AdminHomeRouteResolver;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
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
        yield MenuItem::linkTo(AdminCrudController::class, 'menu.admins', 'fa fa-users');
        yield MenuItem::linkTo(FaqCrudController::class, 'menu.faq', 'fa fa-question-circle');
        yield MenuItem::linkTo(DocumentCrudController::class, 'menu.documents', 'fa fa-file-text');
        yield MenuItem::linkTo(LinkCrudController::class, 'menu.links', 'fa fa-link');
        yield MenuItem::linkTo(SettingCrudController::class, 'menu.settings', 'fa fa-cog');
    }
}
