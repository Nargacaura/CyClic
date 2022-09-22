<?php

/**
 * <h2>DashBoard Controller</h2>
 * <p>Un controller qui permet d'acceder et de gérer un panel admin.</p>
 * @author Antonin Mougenot
 * 
 */

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\User;
use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Signalement;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
  /**
   * <h3>Constructeur</h3>
   * <ul>
   * <li>@param $adminUrlGenerator Génere une url pour accedé au panel admin</li>
   * </ul>
   */

  public function __construct(AdminUrlGenerator $adminUrlGenerator)
  {
    $this->adminUrlGenerator = $adminUrlGenerator;
  }

  /**
   * @Route("/admin", name="admin")
   * 
   * @IsGranted("ROLE_ADMIN")
   * 
   * <h3>Affichage du panel admin</h3>
   * @return admin/my-dashboard.html.twig page d'accueil du panel
   */
  public function index(): Response
  {
    return $this->render('admin/my-dashboard.html.twig');
  }


  /**
   * <h3>Configuration du panel</h3>
   * @return <img src="/img/wordmark.png" width="150px"/> Configure une nouvelle mise en page du menu 
   */
  public function configureDashboard(): Dashboard
  {

    return Dashboard::new()
      ->setTitle('<img src="/img/wordmark.png" width="150px"/>');
  }

  /**
   * <h3>Création des différents menu du dashboard</h3>
   */
  public function configureMenuItems(): iterable
  {

    yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);
    yield MenuItem::linkToCrud('Annonce', 'fas fa-folder', Annonce::class);
    yield MenuItem::linkToCrud('Signalement', 'fas fa-exclamation', Signalement::class);
    yield MenuItem::linkToCrud('Categorie', 'fas fa-list', Categorie::class);
    yield MenuItem::linkToCrud('Etat', 'fas fa-list', Etat::class);
  }
}
