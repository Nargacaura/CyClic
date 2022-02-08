<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EtatFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {


      for ($i = 0; $i < 4; $i++) {
        $etat = new Etat();
        $etat->setNom('etat' . $i);
        $manager->persist($etat);
        $manager->flush();
    }
  }

}

