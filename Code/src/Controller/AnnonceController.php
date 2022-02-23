<?php

namespace App\Controller;

use DateTime;
use App\Entity\Photo;
use App\Entity\Annonce;
use App\Form\PhotoType;
use App\Entity\Categorie;
use App\Form\AnnonceType;
use App\Entity\StatutEchange;
use Doctrine\ORM\Mapping\OrderBy;
use App\Repository\EtatRepository;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use App\Repository\LocalisationRepository;
use App\Repository\MessageRepository;
use App\Repository\StatutEchangeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AnnonceController extends AbstractController
{
    public function getUserLoc()
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        if($user){
          return $user->getLocUser();
        }
        return null;
    }

    /**
     * @Route("/annonce/result", name="annonce_search")
     */
    public function result(Request $request, AnnonceRepository $annonceRepo, CategorieRepository $categRepo, LocalisationRepository $localisations): Response
    {
        $search = $request->get("search");
        $categories = $categRepo->findAll();

        $annonces = $annonceRepo->searchAnnonceSimple($search);

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
            'categories' => $categories,
            'lieux' => $this->getUserLoc()
        ]);
    }

    /**
     * @Route("/annonce/{id}", name="annonce_info")
     */
    // public function show(AnnonceRepository $annonceRepo, Request $request)
    // {
    //     $annonce = $annonceRepo->find($request->get("id"));

    //     // le check marche pas
    //     if($annonce == null) $this->createNotFoundException("pas d'annonce pour cette id");

    //     return $this->render('annonce/show.html.twig', [
    //         'annonce' => $annonce
    //     ]);
    // }

    /**
     * @Route("/annonce", name="annonce")
     */
    public function index(EtatRepository $etatRepository, AnnonceRepository $annonceRepo, CategorieRepository $categRepo, LocalisationRepository $localisations): Response
    {
        $annonces = $annonceRepo->findAll();
        $categories = $categRepo->findAll();
        $etats = $etatRepository->findAll();


        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
            'categories' => $categories,
            'etats' => $etats,
            'lieux' => $this->getUserLoc()
        ]);
    }

    /**
     * @Route("/annonce/tri", name="triAnnonces")
     */
    public function tri(AnnonceRepository $annonceRepo, CategorieRepository $categRepo, Request $request): Response
    {
      $annonces = $annonceRepo->searchAnnonceComplete($request);

        $categories = $categRepo->findAll();
        $value = [ 'recherche' => $request->get("titre"),
          'tri' => $request->get("tri"),
          'categorie' => $request->get("categorie"),
          'etat' => $request->get("etat"),
          'radius' => $request->get("radius")
    ];

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
            'categories' => $categories,
            'value' => $value
        ]);
      }

    /**
     * @Route("/annonce/{id<\d+>}", name="show_details")
     */
    public function showDetails(Annonce $annonce) {

      if (!$annonce) {
          throw $this->createNotFoundException();
      }

      return $this->render("annonce/details.html.twig", [
          'produit' => $annonce,
      ]);
  }

    /**
     * @Route("/annonce/new", name="new_annonce")
     */
    public function addAnnonce(ManagerRegistry $doctrine, Request $request, StatutEchangeRepository $statusRepository)
    {

        if ($this->getUser()) {
            $annonce = new Annonce();

            $form = $this->createForm(AnnonceType::class, $annonce);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $annonce = $form->getData();
                $manager = $doctrine->getManager();
                $annonce->setDatePublication(new DateTime());
                $annonce->setAuteur($this->getUser());
                $annonce->setStatut($statusRepository->getStatusFromName(StatutEchange::open));
                $manager->persist($annonce);
                $manager->flush();

                return $this->redirectToRoute('annonce');
            }
            return $this->render('annonce/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
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

    /**
     * @Route("/app_annonce_delete/{id<\d+>}")
     * @Security("annonce.getAuteur() == user")
     */
    public function delete(Annonce $annonce, EntityManagerInterface $manager, Request $rq, MessageRepository $messages)
    {
        if ($this->isCsrfTokenValid('delete' . $annonce->getId(), $rq->request->get('_token'))) {
            $msg_annonce = $messages->createQueryBuilder("m")
            ->where("m.annonce = :id")
            ->setParameters(array(
                "id" => $annonce->getId()
            ))
            ->getQuery()
            ->execute();
            foreach($msg_annonce as $message){
                $manager->remove($message);
            }
            $manager->remove($annonce);
            $manager->flush();
            $this->addFlash('danger', "L'annonce a bien été supprimée. Adieu, chère annonce... :'(");
        }
        return $this->redirectToRoute('annonce');
    }
}
