<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Etat;
use App\Entity\User;
use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Localisation;
use App\Entity\StatutEchange;
use App\Repository\EtatRepository;
use App\Repository\PhotoRepository;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\LocalisationRepository;
use App\Repository\StatutEchangeRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnnonceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $users = $manager->getRepository(User::class)->findAll();
        $categories = $manager->getRepository(Categorie::class)->findAll();
        $etats = $manager->getRepository(Etat::class)->findAll();
        // $statuts = $manager->getRepository(StatutEchange::class)->findAll();
        $statuts = $manager->getRepository(StatutEchange::class)->findOneBy(array("nom" => StatutEchange::open));

        for ($i = 0; $i < 65; $i++) {
            $annonce = new Annonce();
            /**
             * @var User $user
             */
            $user = $users[(array_rand($users, 1))];
            $annonce->setTitre($faker->text(rand(7, 40)));
            $annonce->setDatePublication($faker->dateTime());
            $annonce->setContenu($faker->paragraph(3));
            $annonce->setAuteur($user );
            $annonce->setLocalisation($user->getLocUser()[0]);
            $annonce->setCategorie($categories[(array_rand($categories, 1))]);
            $annonce->setEtat($etats[(array_rand($etats, 1))]);
            // $annonce->setStatut($statuts[(array_rand($etats, 1))]);
            $annonce->setStatut($statuts);
            $manager->persist($annonce);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            LocalisationFixtures::class,
            CategoriesFixtures::class,
            EtatFixtures::class,
            StatutFixtures::class
        ];
    }
}
