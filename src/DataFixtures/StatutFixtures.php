<?php

namespace App\DataFixtures;

use App\Entity\StatutEchange;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StatutFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (StatutEchange::status as $value) {
            $statut = new StatutEchange();
            $statut->setNom($value);
            $manager->persist($statut);
        }
        $manager->flush();
    }
}
