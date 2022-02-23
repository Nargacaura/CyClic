<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Localisation;
use App\Form\LocalisationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LocalisationController extends AbstractController
{
    /**
     * @Route("/localisation")
     */
    public function index(Request $rq, EntityManagerInterface $entityManager): Response
    {
        $locale = new Localisation();
        $localisationForm = $this->createForm(LocalisationType::class, $locale);
        $localisationForm->handleRequest($rq);

        if ($localisationForm->isSubmitted() && $localisationForm->isValid()) {
            $locale = $localisationForm->getData();
            $user = $entityManager->getRepository(User::class);
            $affectedUser = $user->findOneBy(['id' => 1]); // À modifier pour avoir le bon id!
            $locale->setUserLocalisation($affectedUser);
            $entityManager->persist($locale);
            $entityManager->flush();
            // do anything else you need here, like send an email
            dd('Localisation ajoutée à l\'utilisateur');
            // return $this->redirectToRoute('');
        }
        return $this->renderForm('localisation/index.html.twig', [
            'localisationForm' => $localisationForm
        ]);
    }
}
