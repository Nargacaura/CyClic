<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Message;
use App\Entity\User;
use App\Repository\AnnonceRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/messagerie")
 */
class MessagerieController extends AbstractController
{

    private MessageRepository $messageRepository;
    private AnnonceRepository $annonceRepository;

    public function __construct(MessageRepository $messageRepository, AnnonceRepository $annonceRepository)
    {
        $this->messageRepository = $messageRepository;
        $this->annonceRepository = $annonceRepository;
    }

    
    /**
     * @Route("/own", name="messagerie_own")
     * @Route("/")
     */
    public function index(): Response
    {
        
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('messagerie/index.html.twig', [
            'contacts' => $this->ownSide()
        ]);
    }

    /**
     * @Route("/own/from", name="message_from")
     */
    public function from(Request $request, ManagerRegistry $doctrine, UserRepository $userRepository): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_login');
        }
        $form = $this->formSendMessage(
            $userRepository->find($request->get("userId")), 
            $request, $doctrine);
        $messages = $this->messageRepository->messageFromUserAnnonce($request->get("userId"),$request->get("annonceId"));
        
        return $this->renderForm('messagerie/from.html.twig', [
            'contacts' => $this->ownSide(),
            "messages" => $messages,
            "user" => $this->getUser(),
            "form" => $form
        ]);
    }

    /**
     * @Route("/other", name="messagerie_other")
     */
    public function other(): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('messagerie/other.html.twig', [
            'contacts' => $this->otherSide(),
            "user" =>  $this->getUser()
        ]);
    }
    /**
     * @Route("/other/to", name="message_to")
     */
    public function to(Request $request, ManagerRegistry $doctrine, UserRepository $userRepository): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_login');
        }
        /** @var User $user */
        /** @var User $to */
        $user = $this->getUser();
        $to = $this->annonceRepository->find($request->get("annonceId"))->getAuteur();

        if($user == $to) $this->createNotFoundException("vous ne pouvez envoyez de message à vous-même");

        $contacts = $this->otherSide();
        $form = $this->formSendMessage(
            $to, 
            $request, $doctrine);
        $messages = $this->messageRepository->messageToAnnonce($user->getId(), $request->get("annonceId"));

        return $this->renderForm('messagerie/to.html.twig', [
            'contacts' => $contacts,
            "messages" => $messages,
            "user" => $user,
            "form" => $form
        ]);
    }



    private function ownSide()
    {
        /** @var User $user */
        $user = $this->getUser();
        $annonces = $user->getAnnonces();
        $contacts = array();

        for ($i=0; $i < sizeof($annonces); $i++) { 
            $contacts[$i] = array();
            $contacts[$i]["annonce"] = $annonces[$i];
            $contacts[$i]["contacts"] = array();
            $messages = $annonces[$i]->getMessages();
            
            for ($j=0; $j < sizeof($messages); $j++) { 
                $toAdd = $messages[$j]->getExpediteur();
                if($toAdd != $user && !in_array($toAdd, $contacts[$i]["contacts"])) $contacts[$i]["contacts"][] = $toAdd;
                else{
                    $toAdd = $messages[$j]->getDestinataire();
                    if($toAdd != $user && !in_array($toAdd, $contacts[$i]["contacts"])) $contacts[$i]["contacts"][] = $toAdd;
                }
            }
        }
        
        return $contacts;
    }

    private function otherSide()
    {
        /** @var User $user */
        $user = $this->getUser();
        $messages = $this->messageRepository->findOtherAnnonceSendedMessage($user->getId());
        $annonces = array();
        $contacts = array();
        if($messages != null){
            $annonces[] = $messages[0];
            $toAdd = array();
            $toAdd["annonce"] = $messages[0];
            $toAdd["contacts"] = array($messages[0]);
            $contacts[] = $toAdd;
            foreach ($messages as $value) {
                $flag = false;
                for ($i=0; $i < sizeof($annonces); $i++) { 
                    if($annonces[$i]["id"] == $value["id"]){
                        $flag = true;
                        break;
                    }
                }
                if(!$flag){
                    $annonces[] = $value;
                    $toAdd = array();
                    $toAdd["annonce"] = $value;
                    $toAdd["contacts"] = array($value);
                    $contacts[] = $toAdd;
                }
            }
        }
        return $contacts;
    }
    

    private function formSendMessage(User $to, Request $request, ManagerRegistry $doctrine)
    {
        /** @var User $user */
        $user = $this->getUser();
        $message = new Message;
        
        $form = $this->createFormBuilder($message)
            ->add('contenu', TextType::class, ['attr' => [
                'placeholder' => 'Nom Annonce',
            ]])
            ->add('save', SubmitType::class, ['label' => 'Send message'])
            ->getForm();
            
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $message = $form->getData();
            $message->setExpediteur($user);
            $message->setAnnonce($this->annonceRepository->find($request->get("annonceId")));
            $message->setDestinataire($to);
            $message->setDate(new \DateTime());

            $manager = $doctrine->getManager();
            $manager->persist($message);
            $manager->flush();
        }
        return $form;
    }
}
