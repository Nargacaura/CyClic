<?php

namespace App\Controller;

use App\Entity\User;
use App\Controller\UserCrudController;
use App\Entity\Annonce;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;


class DashboardController extends AbstractDashboardController
{
  
    public function __construct(AdminUrlGenerator $adminUrlGenerator)
  {
    $this->adminUrlGenerator = $adminUrlGenerator;
  }
    /**
     * @Route("/admin", name="admin")
     * 
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {
      //return parent::index();
      return $this->render('admin/my-dashboard.html.twig');
    }



    public function configureDashboard(): Dashboard
    {

        return Dashboard::new()
            ->setTitle('<img src="/img/wordmark.png" width="150px"/>');
            
            
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Annonce', 'fas fa-list', Annonce::class);
        
    }
}
