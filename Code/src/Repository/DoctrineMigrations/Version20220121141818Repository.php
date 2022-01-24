<?php

namespace App\Repository\DoctrineMigrations;

use App\Entity\DoctrineMigrations\Version20220121141818;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Version20220121141818|null find($id, $lockMode = null, $lockVersion = null)
 * @method Version20220121141818|null findOneBy(array $criteria, array $orderBy = null)
 * @method Version20220121141818[]    findAll()
 * @method Version20220121141818[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Version20220121141818Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Version20220121141818::class);
    }

    // /**
    //  * @return Version20220121141818[] Returns an array of Version20220121141818 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Version20220121141818
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
