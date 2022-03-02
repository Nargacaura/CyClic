<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use Faker;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AvatarFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
      $faker = Faker\Factory::create('fr_FR');

      $users = $manager->getRepository(User::class)->findAll();

      foreach($users as $user){
        // foreach($objets as $objet){
            $avatar = new Avatar();
            $avatar->setImageName("avatar_".random_int(0, 5).".png");
            $avatar->setImageSize(1000);
            $avatar->setUser($user);
            $manager->persist($avatar);
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
