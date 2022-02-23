<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CategoriesFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 6; $i++) {
            $categorie = new Categorie();
            $categorie->setNom($faker->word());
            $manager->persist($categorie);
        }

        $manager->flush();
    }

}
