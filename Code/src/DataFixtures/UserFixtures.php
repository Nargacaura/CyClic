<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
  /*
  * @var UserPasswordHasherInterface
  */
  private $hasher;
  public function __construct(UserPasswordHasherInterface $hasher)
  {
      $this->hasher = $hasher;
  }

    public function load(ObjectManager $manager): void
    {
      $faker = Faker\Factory::create('fr_FR'); 
      $password = $this->hasher->hashPassword(new User(), 'password');

      for ($i = 0; $i < 10; $i++) {

      $user = new User();
      $user
        ->setEmail($faker->email());
        $user->setPassword($password)
        ->setDateNaissance($faker->dateTime())
        ->setPseudo($faker->userName())
        ->setNom($faker->lastName())
        ->setPrenom($faker->firstName())
        ->setBan(False)
        ;
        $manager->persist($user);
    }
    $admin = new User();
    $admin
    ->setEmail('admin@mail.com');
    $user->setPassword($password)
    ->setDateNaissance($faker->dateTime())
    ->setPseudo($faker->userName())
    ->setNom($faker->lastName())
    ->setPrenom($faker->firstName())
    ->setRoles(['ROLE_ADMIN'])
    ;
    $manager->persist($user);

    $manager->flush();
  }
}
