<?php

namespace App\DataFixtures;

use App\Entity\CalendarData;
use Faker;
use App\Entity\Message;
use App\Repository\AnnonceRepository;
use App\Repository\UserRepository;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
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

        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 35; $i++) {

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

            $messageNumber = rand(3, 8);
            for ($j = 0; $j < $messageNumber; $j++) {
                $message = new Message();
                $message->setAnnonce($annonce);
                $message->setContenu($faker->text());
                if (rand(0, 1) == 0) {
                    $message->setDestinataire($destinataire);
                    $message->setExpediteur($expediteur);
                } else {
                    $message->setDestinataire($expediteur);
                    $message->setExpediteur($destinataire);
                }
                $message->setDate(DateTimeImmutable::createFromMutable($faker->dateTime()));
                $manager->persist($message);
            }
            $calInfonumber = rand(3, 6);
            for ($j = 0; $j < $calInfonumber; $j++) {
                $calendarInfo = new CalendarData();
                $calendarInfo->setAnnonce($annonce);
                $calendarInfo->setTitre($faker->text((rand(5, 25))));
                if (rand(0, 1) == 0) $calendarInfo->setDescription($faker->text((rand(10, 120))));
                if (rand(0, 1) == 0) {
                    $calendarInfo->setDetenteur($destinataire);
                    $calendarInfo->setDestinataire($expediteur);
                } else {
                    $calendarInfo->setDetenteur($expediteur);
                    $calendarInfo->setDestinataire($destinataire);
                }
                $debut = $faker->dateTimeInInterval('+1 days', '+3 week');
                $calendarInfo->setDebut(DateTimeImmutable::createFromMutable($debut));
                if (rand(0, 1) == 0) $val = strval(rand(1, 5)) . ' day';
                else $val = strval(rand(1, 5)) . ' hour';
                $fin = $debut->add(DateInterval::createFromDateString($val));
                $calendarInfo->setFin(DateTimeImmutable::createFromMutable($fin));
                $manager->persist($calendarInfo);
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
