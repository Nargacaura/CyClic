<?php

namespace App\Controller;

use DateTime;
use App\Entity\Photo;
use App\Entity\Annonce;
use App\Form\PhotoType;
use App\Entity\Categorie;
use App\Form\AnnonceType;
use App\Entity\StatutEchange;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use App\Repository\EtatRepository;
use App\Repository\LocalisationRepository;
use App\Repository\StatutEchangeRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce/result", name="annonce_search")
     */
    public function result(Request $request, AnnonceRepository $annonceRepo, CategorieRepository $categRepo): Response
    {
        $search = $request->get("search");

        $annonces = $annonceRepo->createQueryBuilder("a")
            ->where("a.categorie = :id")
            ->andWhere("a.contenu LIKE :text")
            ->andWhere("a.titre LIKE :text OR a.contenu LIKE :text")
            ->setParameters(array(
                "id" => $search["categorie"],
                "text" => "%" . $search["titre"] . "%"
            ))
            ->getQuery()
            ->execute();

        $categories = $categRepo->findAll();
        $lieux = [];
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
            'categories' => $categories,
            'lieux' => $lieux
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
     * @Route("/annonce/new", name="new_annonce")
     */
    public function addAnnonce(ManagerRegistry $doctrine, Request $request)
    {
        $annonce = new Annonce();

        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $annonce = $form->getData();
            $manager = $doctrine->getManager();
            $annonce->setDatePublication(new DateTime());
            $annonce->setAuteur($this->getUser());
            $manager->persist($annonce);
            // ligne ci-dessous à customiser en fonction de vos id des données dans "statutEchange"
            $statut = $doctrine->getRepository(StatutEchange::class)->findOneBy(['id' => 41]);
            $statut->addAnnonce($annonce);
            $manager->flush();
            dd('insertion en base de données bien effectuée');
        }
        return $this->render('annonce/new.html.twig', [
            'form' => $form->createView(),
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

    /**
     * @Route("/annonce/{id<\d+>}")
     */
    public function showDetails(int $id, 
        AnnonceRepository $repo, 
        UserRepository $users,
        StatutEchangeRepository $stats,
        LocalisationRepository $where,
        CategorieRepository $categories,
        EtatRepository $states
    ){
        $produit = $repo->find($id);
        $user = $users->find($produit->getAuteur());
        $status = $stats->find($produit->getStatut());
        $location = $where->find($produit->getLocalisation());
        $category = $categories->find($produit->getCategorie());
        $state = $states->find($produit->getEtat());



        if(!$produit){
            throw $this->createNotFoundException();
        }

        return $this->render("annonce/details.html.twig", [
            'offre' => $produit,
            'user' => $user,
            'status' => $status,
            'localisation' => $location,
            'category' => $category,
            'state' => $state
        ]);
    }
}
