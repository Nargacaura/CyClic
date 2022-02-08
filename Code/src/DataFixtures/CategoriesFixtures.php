<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 10; $i++) {
            $categorie = new Categorie();
            $categorie->setNom('categorie' . $i);
            $manager->persist($categorie);
        }

        $manager->flush();
    }

}
