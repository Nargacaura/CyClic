<?php

namespace App\Controller;

use App\Entity\Signalement;
use App\Form\SignalementType;
use App\Repository\AnnonceRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SignalementController extends AbstractController
{
    /**
     * @Route("/signalement", name="signalement")
     */
    public function index(Request $request, ManagerRegistry $doctrine, AnnonceRepository $annonceRepository, UserRepository $userRepository): Response
    {
        $signal = new Signalement();
        $form = $this->createForm(SignalementType::class, $signal);
        $form->handleRequest($request);
        $annonce = $annonceRepository->find($request->get("annonceId"));
        $signaleur = $userRepository->find($request->get("signaleur"));

        
        if(!$annonce) {
            throw new NotFoundHttpException('Vous ne pouvez pas ne rien signaler!');
        }
        
        if ($form->isSubmitted() && $form->isValid()) {
            $signal = $form->getData();
            
            $signal->setAnnonce($annonce);
            $signal->setAuteur($signaleur);
            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($signal);
            $entityManager->flush();
            return $this->redirectToRoute('show_details', ['id' => $annonce->getId()]);
        }


        return $this->render('signalement/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
