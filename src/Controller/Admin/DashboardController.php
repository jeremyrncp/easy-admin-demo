<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin")
     */
    public function index(): Response
    {
        $productListUrl = $this->get(CrudUrlGenerator::class)->build()->setController(ProductCrudController::class)->generateUrl();

        return $this->redirect($productListUrl);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Example Backend')
            ->disableUrlSignatures()
            ;
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
                ->addJsFile('js/changelanguage.js')
            ;
    }


    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('menu.product.list', 'fas fa-th-list', Product::class)->setDefaultSort(['createdAt' => 'DESC']);
        yield MenuItem::linkToCrud('menu.category', 'fas fa-tags', Category::class);
        yield MenuItem::linkToCrud('menu.customer', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('menu.purchase', 'far fa-credit-card', Purchase::class)->setDefaultSort(['deliveryDate' => 'DESC']);

    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getUsername())
            ->addMenuItems([
                MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
                MenuItem::section(),
                MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }
}
