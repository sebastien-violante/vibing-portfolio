<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_ADMIN')]
#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator) {}

    public function index(): Response
    {
        return $this->redirect(
            $this->adminUrlGenerator->setController(ProjectCrudController::class)->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Portfolio - Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkTo(ProjectCrudController::class, 'Projets', 'fa fa-folder-open');
        yield MenuItem::linkTo(ProjectImageCrudController::class, 'Images', 'fa fa-image');
        yield MenuItem::linkTo(ProfileCrudController::class, 'Profil', 'fa fa-user');
        yield MenuItem::linkTo(SkillCrudController::class, 'Compétences', 'fa fa-list-check');
    }
}
