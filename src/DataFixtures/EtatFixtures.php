<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtatFixtures extends Fixture
{
    private $etats = [
        "Comme neuf",
        "Bon état",
        "Etat moyen",
        "Mauvais état",
        "A réparer",
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->etats as $value) {
            $etat = new Etat();
            $etat->setNom($value);
            $manager->persist($etat);
        }
        $manager->flush();
    }
}
