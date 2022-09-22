<?php

/**
 * <h1>Contrôleur d'inscription</h1>
 * <p>Permet de gérer l'inscription d'un nouvel user.</p>
 * @author Damien Ledda
 */

namespace App\Controller;

use App\Entity\Localisation;
use App\Entity\User;
use Symfony\Component\Mime\Email;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * <h2>Inscription</h2>
 * <p>Classe de contrôle de l'inscription.</p>
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * <h3>Inscription</h3>
     * @param $request Requête
     * @param $userPasswordHasher hacheur de mots de passe
     * @param $entityManager gestionnaire d'entités
     * @param $mailer gestionnaire de mails
     * @return register.html.twig page d'inscription
     */
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        $user = new User();
        $localisation = new Localisation();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->get("locUser")->getData() as $value) {
                $localisation = $value;
            }
            $localisation->setUserLocalisation($user);
            $user->addLocUser($localisation);
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            /*envoi d'un mail à l'administrateur*/
            $email = new Email();
            $email
                ->from('admin-cyclic@cda2022.com')
                ->to('cdacrousti@gmail.com')
                ->subject('Nouvel utilisateur')
                ->text('L\'utilisateur ' . $user->getEmail() . ' est inscrit, son nom est est : ' . $user->getNom() .
                    ', son prénom est : ' . $user->getPrenom());

            $mailer->send($email);

            /*envoi d'un mail au nouvel utilisateur*/
            $email = new Email();
            $email
                ->from('no-reply@cda2022.com')
                ->to($user->getEmail())
                ->subject('Bienvenue sur Cyclic')
                ->text('Bonjour ' . $user->getPrenom() . ' ' . $user->getNom() .
                    ' Vous êtes désormais inscrit au site Cyclic.<br> Vous pouvez vous connecter en cliquant sur <a href="https://lda.cda-ccicampus.dev/login"> le lien suivant</a>');

            $mailer->send($email);

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
