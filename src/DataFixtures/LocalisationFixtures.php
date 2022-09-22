<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Localisation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LocalisationFixtures extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager): void
  {
    $faker = Faker\Factory::create('fr_FR');
    $users = $manager->getRepository(User::class)->findAll();

    $presicion = 1000000;
    $addedLoc = array();
    for ($i = 0; $i < 20; $i++) {
      $localisation = new Localisation();
      $localisation->setVille($faker->region());
      $localisation->setCodePostal($faker->departmentNumber());
      $localisation->setRue($faker->secondaryAddress());

      $found = false;
      /**
       * @var User $user
       */
      foreach ($users as $user) {
        if (!in_array($user->getId(), $addedLoc)) {
          $localisation->setUserLocalisation($user);
          $addedLoc[] = $user->getId();
          $found = true;
          break;
        }
      }
      if (!$found) $localisation->setUserLocalisation($users[(array_rand($users, 1))]);
      $localisation->setLatitude(rand(43 * $presicion, 50 * $presicion) / $presicion);
      $localisation->setLongitude(rand(-1 * $presicion, 7 * $presicion) / $presicion);
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
