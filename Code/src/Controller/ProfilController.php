<?php

namespace App\Controller;

use App\Entity\Localisation;
use App\Controller\HomeController;
use App\Repository\UserRepository;
use App\Repository\AnnonceRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LocalisationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    private const ANNONCE_SHOW = 5;
    /**
     * @Route("/profil", name="profil")
     */
    public function index(ManagerRegistry $doctrine, UserRepository $userRepository, AnnonceRepository $annonceRepo): Response
    {
        $repo = $doctrine->getRepository(Localisation::class);
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $user->getId();
        $localisation = $repo->findOneBy(['userLocalisation'=>$user]);

        $annonces = $user->getAnnonces();
        // $annonces = $annonceRepo->searchAvailableAnnonce();
        // $annonces = array_slice($annonces, 0, ProfilController::ANNONCE_SHOW);

        $users =$this->getUser();

        return $this->render('profil/index.html.twig', [
            'localisation' => $localisation,
            'users'=> $users,
            'annonces' => $annonces

        ]);
    }
}
