<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Photo;
use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PhotoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
      $faker = Faker\Factory::create('fr_FR');

      $annonces = $manager->getRepository(Annonce::class)->findAll();

      $objets = ["canape", "canape3", "microonde", "velo", "velo3", "velo4", "velo2"];

      $annonceKalach = $annonces[array_rand($annonces)];

      foreach($annonces as $annonce){
        if($annonce == $annonceKalach) continue ;
        $objet = $objets[array_rand($objets)];
        // foreach($objets as $objet){
          for ($i = 0; $i < 3; $i++) {
            $photo = new Photo();
            $photo->setImageName($objet."_".$i.".jpg");
            $photo->setImageSize(1000);
            $photo->setUpdatedAt($faker->dateTime());
            $photo->setAnnonce($annonce);
            $manager->persist($photo);
          }
    
      }

      for ($i = 0; $i < 3; $i++) {
        $photo = new Photo();
        $photo->setImageName("kalachnikov_".$i.".jpg");
        $photo->setImageSize(1000);
        $photo->setUpdatedAt($faker->dateTime());
        $photo->setAnnonce($annonceKalach);
        $manager->persist($photo);
      }

    $manager->flush();
  }

  public function getDependencies()
  {
      return [
          AnnonceFixtures::class,
      ];
  }

}
