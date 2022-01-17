<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Annonce;
use App\Form\PhotoType;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce", name="annonce")
     */
    public function index(AnnonceRepository $annonceRepo, CategorieRepository $categRepo): Response
    {
        $annonces = $annonceRepo->findAll();
        $categories = $categRepo->findAll();
        $grandEst = ['id' => 1, 'nom' => 'Grand Est'];
        $Bretagne = ['id' => 2, 'nom' => 'Bretagne'];
        $Occitanie = ['id' => 3, 'nom' => 'Occitanie'];

        $lieux = [$grandEst, $Bretagne, $Occitanie];

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
            'categories' => $categories,
            'lieux' => $lieux
        ]);
    }

    /**
     * @Route("/photo/new", name="newPhoto")
     */
    public function addPhoto(ManagerRegistry $doctrine, Request $request)
    {
        $photo = new Photo();

        $form = $this->createForm(PhotoType::class, $photo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->getData();
            $manager = $doctrine->getManager();
            $annonceRepo = $manager->getRepository(Annonce::class);
            $annonce = $annonceRepo->findOneBy(['id' => 1]);
            $photo->setAnnonce($annonce);
            $manager->persist($photo);
            $manager->flush();
            dd('insertion en base de données bien effectuée');
        }
        return $this->render('annonce/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'AnnonceController',
        ]);
    }
}
