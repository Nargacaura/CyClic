<?php

namespace App\Repository;

use App\Entity\StatutEchange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatutEchange|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatutEchange|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatutEchange[]    findAll()
 * @method StatutEchange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutEchangeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatutEchange::class);
    }

    // /**
    //  * @return StatutEchange[] Returns an array of StatutEchange objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatutEchange
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
