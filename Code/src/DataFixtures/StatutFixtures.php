<?php

namespace App\DataFixtures;

use App\Entity\StatutEchange;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StatutFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

      for ($i = 0; $i < 10; $i++) {
        $statut = new StatutEchange();
        $statut->setNom($i);
        $manager->persist($statut);
    }

        $manager->flush();
    }
}
