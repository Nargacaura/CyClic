<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Annonce;
use App\Form\PhotoType;
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
    public function index(): Response
    {
        return $this->render('annonce/index.html.twig', [
            'controller_name' => 'AnnonceController',
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
