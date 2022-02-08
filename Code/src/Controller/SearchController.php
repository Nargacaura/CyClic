<?php

namespace App\Controller;
use App\Form\SeachType;
use App\Repository\AnnonceRepository;
use App\Repository\LocalisationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     * @param Request $request
     */
    
    public function searchAnnonce(Request $request, AnnonceRepository $annonceRepo, LocalisationRepository $localisationRepository): Response
    {

    

        $annonces = [];
        $form = $this->createForm(SeachType::class);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
            $annonces = $localisationRepository->searchAnnonce($search);
            $annonces = $annonceRepo->searchAnnonce($search);
            // dump(sizeof($annonces));
            // $annonces = $categorieRepository->searchAnnonce($search);
            dump($annonces);
        }
        
        return $this->renderForm('search/index.html.twig', [
            'search_form' => $form,
            'annonces' => $annonces
        ]);
    }
}
