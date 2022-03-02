<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Message;
use App\Entity\StatutEchange;
use App\Entity\Transaction;
use App\Repository\MessageRepository;
use App\Repository\StatutEchangeRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TransactionFixture extends Fixture implements DependentFixtureInterface
{
    private MessageRepository $messageRepository;
    private StatutEchangeRepository $statutRepository;

    public function __construct(MessageRepository $messageRepository, StatutEchangeRepository $statutRepository)
    {
        $this->messageRepository = $messageRepository;
        $this->statutRepository = $statutRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $messages = $this->messageRepository->findAll();

        $oneValidation = 4;
        $rated = 7;
        $total = $oneValidation + $rated;
        for ($i=0; $i < $total ; $i++) { 
            
            /**
             * @var Message $message
             */
            $message = $messages[array_rand($messages)];

            /**
             * @var Annonce $ann
             */
            $ann = $message->getAnnonce();

            foreach ($messages as $key => $value) {
                if($value->getAnnonce() == $ann) unset($messages[$key]);
            }
            $transac = new Transaction();
            $transac->setAnnonce($ann);
            $transac->setDonneur($ann->getAuteur());
            $transac->setReceveur(($message->getExpediteur() == $ann->getAuteur()) ? $message->getDestinataire() : $message->getExpediteur());
            $transac->setValidationDonneur(true);
            if($i >= $oneValidation){
                $transac->setValidationReceveur(true);
                $transac->setNoteReceveur(rand(1, 5));
                $transac->setNoteDonneur(rand(1, 5));
                $ann->setStatut($this->statutRepository->getStatusFromName(StatutEchange::validated));
            }
            else{
                $transac->setValidationReceveur(false);
                $ann->setStatut($this->statutRepository->getStatusFromName(StatutEchange::inValidation));
            }
            $manager->persist($transac);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            MessageFixture::class
        ];
    }
}
