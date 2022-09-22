<?php
/**
 * <h1>Controller des annonces</h1>
 */

namespace App\Controller;

use DateTime;
use App\Entity\Annonce;
use App\Entity\Localisation;
use App\Form\AnnonceType;
use App\Entity\StatutEchange;
use App\Repository\EtatRepository;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use App\Repository\MessageRepository;
use App\Repository\StatutEchangeRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AnnonceController extends AbstractController
{
  /**
   * <h2>Récupère la localisation de l'utilisateur actuellement connecté</h2>
   * @return $user->getLocUser(); ||  @return null;
   * @author DUCHESNE Florian
   */
  public function getUserLoc()
  {
    /**
     * @var User $user
     */
    $user = $this->getUser();
    if ($user) {
      return $user->getLocUser();
    }
    return null;
  }

  /**
   * @Route("/annonce/result", name="annonce_search")
   * <h2>Recherce le résultat d'une recherche d'annonce</h2>
   * @param $request
   * @param $annonceRepo
   * @param $categRepo
   * @return $this->render('annonce/index.html.twig', ['annonces' => $annonces,'locData' => $this->localisationData($annonces),'categories' => $categories,'lieux' => $this->getUserLoc(),'tri' => null]);
   * @author DUCHESNE Florian
   */
  public function result(Request $request, AnnonceRepository $annonceRepo, CategorieRepository $categRepo)
  {
    $search = $request->get("search");
    $categories = $categRepo->findAll();

    $annonces = $annonceRepo->searchAnnonceSimple($search);

    return $this->render('annonce/index.html.twig', [
      'annonces' => $annonces,
      'locData' => $this->localisationData($annonces),
      'categories' => $categories,
      'lieux' => $this->getUserLoc(),
      'tri' => null
    ]);
  }

  /**
   * <h2>Récupère les localisations des différentes annonces</h2>
   * @param $annonces
   * @return $locData;
   * @author SCHAEFFER Léonard
   */
  public function localisationData($annonces)
  {
    $locData = array();
    /**
     * @var Annonce $ann
     */
    foreach ($annonces as $ann) {
      $photos = $ann->getPhotos();
      $photo = ($photos != null && sizeof($photos) > 0) ? $photos[0]->getImageName() : null;
      $locData[] = [
        "annonce" => $ann->getId(),
        "photo" => $photo,
        "title" => $ann->getTitre(),
        "lon" => $ann->getLocalisation()->getLongitude(),
        "lat" => $ann->getLocalisation()->getLatitude()
      ];
    }
    return $locData;
  }

  /**
   * @Route("/annonce", name="annonce")
   * <h2>Récupère et affiche toutes les annonces</h2>
   * @param $etatRepository
   * @param $annonceRepo
   * @param $categRepo
   * @return $this->render('annonce/index.html.twig', ['annonces' => $annonces,'locData' => $this->localisationData($annonces),'categories' => $categories,'etats' => $etats'lieux' => $this->getUserLoc(),'tri' => null]);
   * @author DUCHESNE Florian
   */
  public function index(EtatRepository $etatRepository, AnnonceRepository $annonceRepo, CategorieRepository $categRepo): Response
  {
    $annonces = $annonceRepo->searchAnnonceSimple(null);
    $categories = $categRepo->findAll();
    $etats = $etatRepository->findAll();


    return $this->render('annonce/index.html.twig', [
      'annonces' => $annonces,
      'locData' => $this->localisationData($annonces),
      'categories' => $categories,
      'etats' => $etats,
      'lieux' => $this->getUserLoc(),
      'tri' => null
    ]);
  }

  /**
   * @Route("/annonce/tri", name="triAnnonces")
   * <h2>Réalise le trie des annonces par localisation, par radius, catégorie et état de l'objet</h2>
   * @param $doctrine
   * @param $categRepo
   * @param $request
   * @return return $this->render('annonce/index.html.twig', ['annonces' => $annonces,'locData' => $this->localisationData($annonces),'categories' => $categories,'value' => $value,'tri' => $request->get("tri")]);
   * @author DUCHESNE Florian
   */
  public function tri(ManagerRegistry $doctrine, CategorieRepository $categRepo, Request $request)
  {
    if ($this->getUser()) {
      $localisation = $request->get("localisation");
      if ($localisation == null) {
        $localisation = $doctrine->getRepository(Localisation::class)->findOneByUserLocalisation($this->getUser());
      } else {
        $localisation = $doctrine->getRepository(Localisation::class)->findOneById($localisation);
      }
      $lat =  $localisation->getLatitude();
      $lng =  $localisation->getLongitude();
    } 
    else {
      $lat =  $request->get("visitorLat");
      $lng =  $request->get("visitorLng");
    }
    $annonces = $doctrine->getRepository(Annonce::class)->searchAnnonceComplete($request, $lat, $lng);
    $categories = $categRepo->findAll();
    $value = [
      'recherche' => $request->get("titre"),
      'tri' => $request->get("tri"),
      'categorie' => $request->get("categorie"),
      'etat' => $request->get("etat"),
      'radius' => $request->get("radius"),
      'localisation' => $request->get("localisation"),
      'lat' => $lat,
      'lon' => $lng
    ];

    return $this->render('annonce/index.html.twig', [
      'annonces' => $annonces,
      'locData' => $this->localisationData($annonces),
      'categories' => $categories,
      'value' => $value,
      'tri' => $request->get("tri")
    ]);
  }

  /**
   * @Route("/annonce/{id<\d+>}", name="show_details")
   * <h2>Affiche le détaille de l'annonce sélectionné</h2>
   * @param $annonce
   * @param $transactionRepository
   * @return $this->render("annonce/details.html.twig", ['produit' => $annonce,'rating' => $rate]);
   * @author DUCHESNE Florian
   */
  public function showDetails(Annonce $annonce, TransactionRepository $transactionRepository)
  {

    if (!$annonce) {
      throw $this->createNotFoundException();
    }

    $rate = $transactionRepository->getUserRating($annonce->getAuteur()->getId());

    return $this->render("annonce/details.html.twig", [
      'produit' => $annonce,
      'rating' => $rate
    ]);
  }

  /**
   * @Route("/annonce/new", name="new_annonce")
   * @Route("/annonce/edit/{id}", name="edit_annonce")
   * <h2>Créer ou modifie une annonce</h2>
   * @param $doctrine
   * @param $request
   * @param $statusRepository
   * @param $annonce = null
   * @return $this->redirectToRoute('show_details', ['id' => $annonce->getId(),]);
   * <h3>else</h3>
   * @return $this->render('annonce/new.html.twig', ['form' => $form->createView(),]);
   * <h3>else</h3>
   * @return $this->redirectToRoute('app_login');
   * @author DUCHESNE Florian
   */
  public function addAnnonce(ManagerRegistry $doctrine, Request $request, StatutEchangeRepository $statusRepository, Annonce $annonce = null)
  {

    if ($this->getUser()) {
      if (($request->get("id") && $annonce) && $annonce->getId() == $request->get("id")) {
        $newAnnonce = false;
      } else {
        $annonce = new Annonce();
        $newAnnonce = true;
      }
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

        return $this->redirectToRoute('show_details', [
          'id' => $annonce->getId(),
        ]);
      }
      if ($newAnnonce == false) {
        if ($this->getUser() == $annonce->getAuteur()) {
          return $this->render('annonce/edit.html.twig', [
            'id' => $annonce->getId(),
            'form' => $form->createView(),
          ]);
        } else {
          throw new $this->createAccessDeniedException();
        }
      } else {
        return $this->render('annonce/new.html.twig', [
          'form' => $form->createView(),
        ]);
      }
    } else {
      return $this->redirectToRoute('app_login');
    }
  }


  /**
   * @Route("/app_annonce_delete/{id<\d+>}")
   * @Security("annonce.getAuteur() == user")
   * <h2>Supprime l'annonce de l'utilisateur connecté</h2>
   * @param $annonce
   * @param $manager
   * @param $rq
   * @param $messages
   * @return $this->redirectToRoute('profil', ['user' => $annonce->getAuteur()->getId(),]);
   * @author DUCHESNE Florian
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
      foreach ($msg_annonce as $message) {
        $manager->remove($message);
      }
      $manager->remove($annonce);
      $manager->flush();
      $this->addFlash('danger', "L'annonce a bien été supprimée. Adieu, chère annonce... :'(");
    }
    return $this->redirectToRoute('profil', [
      'user' => $annonce->getAuteur()->getId(),
    ]);
  }
}
