<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture 
{
    private $cats =[
        "Meubles",
        "Appareils",
        "Fournitures",
        "Outils",
        "Loisirs & Sports",
        "Véhicules",
        "Vêtements",
        "Bijoux",
        "Autres"
    ];

    public function load(ObjectManager $manager): void
    {

        foreach ($this->cats as $value) {
            $categorie = new Categorie();
            $categorie->setNom($value);
            $manager->persist($categorie);
        }
        $manager->flush();
    }

}
