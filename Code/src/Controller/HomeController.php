<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Localisation;
use App\Form\LocalisationType;
use App\Form\SearchAnnType;
use App\Form\SearchType;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use CategoryType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    private const ANNONCE_SHOW = 4;

    /**
     * @Route("/home", name="home")
     * @Route("/")
     */
    public function index(Request $request, ManagerRegistry $doctrine, AnnonceRepository $annonceRepo, CategorieRepository $catRepo): Response
    {
        
        $form = $this->createForm(SearchType::class, null, [
            'action' => $this->generateUrl('annonce_search'),
            'required' => false
        ]);

        // $form->handleRequest($request);
        // if ($form->isSubmitted() && $form->isValid()) {
        //     $search = $form->getData();
        //     /*dump($search);
        //     die;*/
            
        // return $this->redirectToRoute('annonce_search', $search, Response::HTTP_SEE_OTHER);
            
        // }

        $annonces = $annonceRepo->searchAvailableAnnonce();
        $annonces = array_slice($annonces, 0, HomeController::ANNONCE_SHOW);
        
        return $this->renderForm('home/index.html.twig', [
            'form' => $form,
            'annonces' => $annonces
        ]);
    }
}
