<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Message;
use App\Repository\AnnonceRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MessageFixture extends Fixture implements DependentFixtureInterface
{
    private UserRepository $userRepository;
    private AnnonceRepository $annonceRepository;

    public function __construct(UserRepository $userRepository, AnnonceRepository $annonceRepository)
    {
        $this->userRepository = $userRepository;
        $this->annonceRepository = $annonceRepository;
    }
    
    public function load(ObjectManager $manager): void
    {
        $users = $this->userRepository->findAll();
        //$annonces = $this->annonceRepository->findAll();

        $faker = Faker\Factory::create('fr_FR'); 
        for ($i = 0; $i < 10; $i++) {

            $expediteur = $users[array_rand($users)];

            $annonces = $this->annonceRepository->createQueryBuilder("a")
                ->where("a.auteur != :id") 
                ->setParameters(array(
                    "id" => $expediteur->getId()
                    ))
                ->getQuery()
                ->execute();

            $annonce  = $annonces[array_rand($annonces)];
            $destinataire = $annonce->getAuteur();

            $message = new Message();
            $message->setAnnonce($annonce);
            $message->setContenu($faker->text());
            $message->setDestinataire($destinataire);
            $message->setExpediteur($expediteur);
            $message->setDate(DateTimeImmutable::createFromMutable($faker->dateTime()));
            $manager->persist($message);

            for ($j = 0; $j < 7; $j++) {
                $message = new Message();
                $message->setAnnonce($annonce);
                $message->setContenu($faker->text());
                if(rand(0, 1) == 0){
                    $message->setDestinataire($destinataire);
                    $message->setExpediteur($expediteur);
                }
                else{
                    $message->setDestinataire($expediteur);
                    $message->setExpediteur($destinataire);
                }
                $message->setDate(DateTimeImmutable::createFromMutable($faker->dateTime()));
                $manager->persist($message);
            }
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            AnnonceFixtures::class
        ];
    }
}
