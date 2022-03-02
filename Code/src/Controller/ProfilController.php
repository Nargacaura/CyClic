<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Localisation;
use App\Form\ProfilEditType;
use App\Repository\UserRepository;
use App\Repository\AnnonceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**s
 * <h2>ProfilController</h2>
 * <p>Un controller qui permet de diriger l'utilisateur à sa page utilisateur
 * et à l'édition du profil.</p>
 * @author Antonin Mougenot
 * 
 */
class ProfilController extends AbstractController
{

    /**
     * @Route("/profil/{user}", name="profil")
     *
     * <h3>Affichage du profil</h3>
     * <ul>
     * <li>@param $doctrine le gestionnaire d'entités</li>
     * <li>@param $pseudo le pseudo de l'user</li>
     * <li>@param $userRepository la table des utilisateurs de la bdd</li>
     * <li>@param $annonceRepo la table des annonces de la bdd</li>
     * </ul>
     * @return profil/index.html.twig page du profil de l'utilisateur connecté 
     */
    public function index(ManagerRegistry $doctrine, User $user, UserRepository $userRepository, AnnonceRepository $annonceRepo): Response
    {
        $repo = $doctrine->getRepository(Localisation::class);
        // /**
        //  * @var User $user
        //  */
        // $user = $userRepository->findOneBy(['pseudo' => $pseudo]);

        // if (!$user) {
        //     throw new NotFoundHttpException('Pas là.');
        // }

        // $id = $user->getId();
        $localisation = $repo->findOneBy(['userLocalisation' => $user]);
        $annonces = $user->getAnnonces();
        // $annonces = $annonceRepo->searchAvailableAnnonce();
        // $annonces = array_slice($annonces, 0, ProfilController::ANNONCE_SHOW);

        // $users = $this->getUser();

        if ($this->getUser() == $user) {
            return $this->render('profil/index.html.twig', [
                'localisation' => $localisation,
                // 'users' => $user,
                'annonces' => $annonces
            ]);
        } else {
            return $this->render("bundles/TwigBundle/Exception/error403.html.twig");
        }
    }

    /**
     * @Route("/profil/edit/{id}", name="editProfil")
     *
     * <h3>Edition du profil</h3>
     * <ul>
     * <li>@param $doctrine le gestionnaire d'entités</li>
     * <li>@param $id l'id de l'utilisateur</li>
     * <li>@param $userRepository la table des utilisateurs de la bdd</li>
     * <li>@param $request créer une requête </li>
     * </ul>
     * @return profil/edit.html.twig page de l'édition du profil  de l'utilisateur
     */
    public function edit(UserRepository $users, ManagerRegistry $doctrine, int $id, Request $request, User $user): Response
    {
        /**
         * @var User $user
         */
        $user = $users->findOneBy(['id' => $id]);
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id ' . $user->getId()
            );
        }
        $form = $this->createForm(ProfilEditType::class, $user);
        $entityManager = $doctrine->getManager();
        $form->handleRequest($request);
        if ($user->getPseudo() != $form->getData()->getPseudo()) {
            if ($form->isSubmitted() && $form->isValid()) {
                $user->setPseudo($form->getData()->getPseudo());
            }
        }
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            $user->setNom($form->getData()->getNom());
            $user->setPrenom($form->getData()->getPrenom());
            $user->setEmail($form->getData()->getEmail());
            $user->setAvatar($form->getData()->getAvatar());
            $entityManager->flush();

            return $this->redirectToRoute("profil", [
                "pseudo" => $user->getPseudo(),
                "users" => $user,
                "localisation" => $user->getLocUser(),
                'annonces' => $user->getAnnonces()
            ]);
        }

        return $this->render('profil/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
