<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */

    public function index(Request $request, MailerInterface $mailer): Response
    {

        //MailerInterface $mailer;

       
        $formBuilder = $this->createFormBuilder();
        
        $formBuilder
          ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new Length(null, 3, 20),
                    new Regex('/[A-Za-z]+/')
                ]
            ])  
            ->add('lastname', TextType::class, ['label' => 'Nom'])
            ->add('email', EmailType::class, ['label' => 'Votre Email'], 
            ['constraints' => 
                    [new NotBlank(
                        ['message' => 'Veuillez rentrer votre adresse mail.',]),
                    ],
                'label' => false
            ])
            ->add('comment', TextType::class, ['label' => 'Votre message'])
        ;


        $form = $formBuilder->getForm();
        // on dit au formulaire d'écouter la requête
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
                      
            // récupérer les infos du formulaire; ici on récupère l'email
            $email_user = $form->get('email')->getData();

            // récupérer les infos du formulaire; ici on récupère le commentaire
            $comment = $form->get('comment')->getData();

            $firstname_user = $form->get('firstname')->getData();
            $lastname_user = $form->get('lastname')->getData();

            // envoie de mail
            $email = new Email();
            $email
                ->from($email_user)
                ->to('cdacrousti@gmail.com')
                ->subject('Message utilisateur')
                ->text("Vous avez reçu le commentaire suivant de ".$email_user." , prénom : .".$firstname_user." nom : ".$lastname_user." : ".$comment)
                ;

            $mailer->send($email);

            };

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form->createView()
        ]);
    }

    


}
