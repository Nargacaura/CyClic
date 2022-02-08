<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Localisation;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LocalisationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
      $faker = Faker\Factory::create('fr_FR'); 
      $users = $manager->getRepository(User::class)->findAll();

      for ($i = 0; $i < 20; $i++) {
        $localisation = new Localisation();
        $localisation->setVille($faker->region());
        $localisation->setCodePostal($faker->departmentNumber());
        $localisation->setRue($faker->secondaryAddress());
        $localisation->setUserLocalisation($users[(array_rand($users, 1))]);
        $manager->persist($localisation);
    }
    $manager->flush();
  }

  public function getDependencies()
  {
      return [
          UserFixtures::class,
      ];
  }

}
