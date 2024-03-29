<?php

namespace App\Repository;

use App\Entity\Localisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Localisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Localisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Localisation[]    findAll()
 * @method Localisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Localisation::class);
    }

    // /**
    //  * @return Localisation[] Returns an array of Localisation objects
    //  */

    public function searchAnnonce($search)
    {
        return $this->createQueryBuilder('l')

            ->where('l.ville = :ville')
            ->setParameter('ville', $search['localisation'])
            ->getQuery()
            ->getResult();
    }
}
