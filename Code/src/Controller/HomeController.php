<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Localisation;
use App\Form\LocalisationType;
use CategoryType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $annonce = new Annonce();
        $annonce->setTitre('Recherche');
        $annonce->setLocalisation(new Localisation());
        $annonce->setCategorie(new Categorie);

        $form = $this->createFormBuilder($annonce)
            ->add('categorie', CategoryType::class)
            ->add('localisation', LocalisationType::class)
            ->add('titre', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Search Annonce'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
            // $entityManager = $doctrine->getManager();
            // $entityManager->persist($search);
            // $entityManager->flush();
            return new Response('Search for : ');
        }

        return $this->renderForm('home/index.html.twig', [
            'form' => $form
        ]);
    }
}
