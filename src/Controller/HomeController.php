<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private const ANNONCE_SHOW = 4;

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, ManagerRegistry $doctrine, AnnonceRepository $annonceRepo, CategorieRepository $catRepo): Response
    {

        $form = $this->createForm(SearchType::class, null, [
            'action' => $this->generateUrl('annonce_search'),
            'required' => false
        ]);

        $annonces = $annonceRepo->searchAvailableAnnonce();
        $annonces = array_slice($annonces, 0, HomeController::ANNONCE_SHOW);

        return $this->renderForm('home/index.html.twig', [
            'form' => $form,
            'annonces' => $annonces
        ]);
    }
}
