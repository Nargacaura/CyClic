<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Localisation;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    
    public function searchAnnonce($search)
    {
        return $this->createQueryBuilder('a')
        
            
            ->where('a.titre = :titre')
            ->setParameter('titre', $search['titre'])
           
            ->innerJoin(categorie::class, 'c', Join::WITH, 'a.categorie = c.id')
            ->andWhere('c.nom = :nom')
            ->setParameter('nom', $search['categorie']->getNom())
        
            ->innerJoin(localisation::class, 'l', Join::WITH, 'a.localisation = l.id')
            ->andWhere('l.ville = :ville')
            ->setParameter('ville', $search['localisation'])
        
            ->getQuery()
            ->getResult()
        ;
    }

     /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
