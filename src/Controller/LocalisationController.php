<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Localisation;
use App\Form\LocalisationType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/localisation")
 */
class LocalisationController extends AbstractController
{
    /**
     * @Route("/", name="localisation")
     */
    public function index(Request $rq, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException();
        }
        /**
         * @var User $user
         */
        $user = $this->getUser(); 

        $locale = new Localisation();
        $localisationForm = $this->createForm(LocalisationType::class, $locale);

        $localisationForm->handleRequest($rq);

        $localisations = $user->getLocUser();

        if ($localisationForm->isSubmitted() && $localisationForm->isValid()) {
            $locale = $localisationForm->getData();
            $locale->setUserLocalisation($user);
            $entityManager->persist($locale);
            $entityManager->flush();
            
            // return $this->redirectToRoute('');
        }
        return $this->renderForm('localisation/index.html.twig', [
            'localisationForm' => $localisationForm,
            'localisationList' => $localisations
        ]);
    }
    
    /**
     * @Route("/delete/{id}", name="delete_localisation", methods={"DELETE"})
     */
    public function delete(Request $request, Localisation $localisation, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException();
        }
        if ($this->isCsrfTokenValid('delete' . $localisation->getId(), $request->get('_token'))
            && $localisation->getUserLocalisation() == $this->getUser()) {
            $entityManager->remove($localisation);
            $entityManager->flush();
        }
        return $this->redirectToRoute('localisation', [], Response::HTTP_SEE_OTHER);
    }

}
