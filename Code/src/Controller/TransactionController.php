<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\StatutEchange;
use App\Entity\Transaction;
use App\Entity\User;
use App\Repository\AnnonceRepository;
use App\Repository\StatutEchangeRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Proxies\__CG__\App\Entity\StatutEchange as EntityStatutEchange;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\throwException;

class TransactionController extends AbstractController
{
    public ObjectManager $manager;
    public TransactionRepository $repository;
    
    public function __construct(ManagerRegistry $doctrine, TransactionRepository $repository)
    {
        $this->manager = $doctrine->getManager();
        $this->repository = $repository;
    }


    /**
     * @Route("/transaction/rate", name="transaction_rate")
     */
    public function rate(Request $request, AnnonceRepository $annonceRepository, StatutEchangeRepository $statusRepository)
    {
        $annonce = $annonceRepository->find($request->get("annonceId"));
        $transaction = $annonce->getTransaction();

        if(!$transaction) 
            return $this->createAccessDeniedException("Vous ne pouvez pas noter cette échange"); 

        if (!$annonce->getStatut($statusRepository->getStatusFromName(StatutEchange::validated))) {
            return $this->createAccessDeniedException("L'échange doit être terminé pour être noté"); 
        }

        if($transaction->getReceveur() == $this->getUser()) $transaction->setNoteReceveur($request->get("rating"));
        else $transaction->setNoteDonneur($request->get("rating"));

        $this->manager->flush();
        
        return $this->redirect($request->headers->get('referer'));
    }
    
    /**
     * @Route("/transaction/cancel", name="transaction_cancel")
     */
    public function cancel(Request $request, AnnonceRepository $annonceRepository, StatutEchangeRepository $statusRepository)
    {
        $annonce = $annonceRepository->find($request->get("annonceId"));
        $transaction = $annonce->getTransaction();
        if(!$transaction || !$annonce->getStatut($statusRepository->getStatusFromName(StatutEchange::inValidation))){
            return $this->$this->createAccessDeniedException("Vous ne pouvez pas annuler cette échange"); 
        }
        
        if($transaction->getReceveur() == $this->getUser() ){
            $transaction->setValidationReceveur(false);
        }
        else if($transaction->getDonneur() == $this->getUser()){
            $transaction->setValidationDonneur(false);
        }
        else return $this->createAccessDeniedException("Vous ne pouvez pas annuler cette échange"); 
        $this->manager->remove($transaction);
        $annonce->setStatut($statusRepository->getStatusFromName(StatutEchange::open));
        
        $this->manager->flush();
        
        return $this->redirect($request->headers->get('referer'));
    }
    
    /**
     * @Route("/transaction/validation", name="transaction_validation")
     */
    public function validation(Request $request, AnnonceRepository $annonceRepository, UserRepository $userRepository, StatutEchangeRepository $statusRepository)
    {
        $annonce = $annonceRepository->find($request->get("annonceId"));
        $receiver = $request->get("receiverId");
        $userIsReceiver = is_null($receiver);
        if(!$userIsReceiver){
            $giver = $this->getUser();
            $receiver = $userRepository->find($receiver);
        }
        else {
            $giver = $annonce->getAuteur();
            $receiver = $this->getUser();
        }

        $transaction = $this->getTransaction($annonce, $giver, $receiver);
        if(!$transaction) return $this->createNotFoundException("Vous ne pouvez pas intérargir avec cette annonce"); 

        if(!$userIsReceiver){
            $transaction->setValidationDonneur(true);
            $annonce->setStatut($statusRepository->getStatusFromName(
                $transaction->getValidationReceveur() 
                    ? StatutEchange::validated 
                    : StatutEchange::inValidation
            ));
        }
        else{
            $transaction->setValidationReceveur(true);
            $annonce->setStatut($statusRepository->getStatusFromName(
                $transaction->getValidationDonneur() 
                    ? StatutEchange::validated 
                    : StatutEchange::inValidation
            ));
        }
        $this->manager->flush();

        return $this->redirect($request->headers->get('referer'));
    }



    private function getTransaction(Annonce $annonce, User $giver, User $receiver)
    {
        $transaction = $annonce->getTransaction();
        if(!$transaction){
            $transaction = new Transaction();
            $transaction->setAnnonce($annonce);
            $transaction->setDonneur($giver);
            $transaction->setReceveur($receiver);
            $transaction->setValidationDonneur(false);
            $transaction->setValidationReceveur(false);
            $this->manager->persist($transaction);
        }
        else {
            if($transaction->getReceveur() != $receiver || $transaction->getDonneur() != $giver){
                return null;
            }
        }
        return $transaction;
    }
}
