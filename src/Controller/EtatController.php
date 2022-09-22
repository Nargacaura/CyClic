<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Form\EtatFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EtatController extends AbstractController
{

    /**
     * @Route("/addEtat", name="etat")
     */

    public function etat(Request $request, ManagerRegistry $doctrine): Response
    {
        $etat = new Etat();
        $etat->setNom('Nom Etat');

        $form = $this->createForm(EtatFormType::class, $etat);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etat = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($etat);
            $entityManager->flush();

            return new Response('Nouvelle etat ' . $etat->getNom() . ' and id : ' . $etat->getId());
        }

        return $this->renderForm('etat/etat.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/default", name="default")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
