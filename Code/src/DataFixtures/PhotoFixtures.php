<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PhotoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

      $annonces = $manager->getRepository(Annonce::class)->findAll();

      for ($i = 0; $i < 10; $i++) {
        $photo = new Photo();
        $photo->setPath('/public_html/img/ '.$i);
        $photo->setAnnonce($annonces[(array_rand($annonces, 1))]);
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
