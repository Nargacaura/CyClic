<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Localisation;
use App\Entity\StatutEchange;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{

    private $statusRepo;

    public function __construct(ManagerRegistry $registry, StatutEchangeRepository $statusRepo)
    {
        parent::__construct($registry, Annonce::class);
        $this->statusRepo = $statusRepo;
    }

    public function searchAvailableAnnonce(int $limit = 20)
    {
        return $this->findBy(
            array('statut' => $this->statusRepo->getStatusFromName(StatutEchange::open)),
            array('datePublication' => 'DESC'),
            $limit
        );
    }

    public function searchAnnonceSimple($search)
    {
        $query = $this->createQueryBuilder("a");
        $query->andWhere("a.contenu LIKE :text")
            ->andWhere("a.titre LIKE :text OR a.contenu LIKE :text")
            ->setParameters(array(
                "text" => "%" . $search["titre"] . "%"
            ))
            ->andWhere("a.statut = :status")
            ->setParameter('status', $this->statusRepo->getStatusFromName(StatutEchange::open));
        if($search["categorie"])
        {
            $query->andWhere("a.categorie = :idCat")
                ->setParameter("idCat", $search["categorie"]);
        }
        return $query->getQuery()
            ->execute();
    }

    public function searchAnnonceComplete($request, $allStatus = false)
    {
        $query = $this->createQueryBuilder("a");

        if(!$allStatus){
            $status = $request->get("statut");
            if(!$status) $status = $this->statusRepo->getStatusFromName(StatutEchange::open);
            $query->andWhere("a.statut = :statut")
                ->setParameter("statut", $status);
        }
        if($request->get("categorie"))
        {
            $query->andWhere("a.categorie = :idCat")
                ->setParameter("idCat", $request->get("categorie"));
        }
        if($request->get("etat"))
        {
            $query->andWhere("a.etat = :idEtat")
                ->setParameter("idEtat", $request->get("etat"));
        }
        if($request->get("titre"))
        {
            $query->andWhere("a.titre LIKE :text OR a.contenu LIKE :text")
                ->setParameter("text", "%" . $request->get("titre") . "%");
        }
          switch($request->get("tri")){
            case 1:
              $query->orderBy('a.datePublication', 'ASC');
              break;
            case 2:
              $query->orderBy('a.titre', 'ASC');
              break;
            default:
              $query->orderBy('a.datePublication', 'DESC');
          } 
        // if($status)
        // {
        //     if(!is_numeric($status)) $status = $this->statusRepo->getStatusFromName($status);
        //     $query->andWhere("a.statut = :statut")
        //         ->setParameter("statut", $status);
        // }
        // if($orderBy){
        //     foreach ($orderBy as $key => $value) {
        //         $query->addOrderBy($key, $value);
        //     }
        // }
        // if(array_key_exists("categorie",$search))
        // {
        //     $query->andWhere("a.categorie = :idCat")
        //         ->setParameter("idCat", $search["categorie"]);
        // }
        // if(array_key_exists("etat",$search))
        // {
        //     $query->andWhere("a.etat = :idEtat")
        //         ->setParameter("idEtat", $search["etat"]);
        // }
        // if(array_key_exists("contain",$search))
        // {
        //     $query->andWhere("a.titre LIKE :text OR a.contenu LIKE :text")
        //         ->setParameter("text", "%" . $search["contain"] . "%");
        // }
        // if(array_key_exists("statut",$search))
        // {
        //     $query->andWhere("a.statut = :statut")
        //         ->setParameter("statut", $search["statut"]);
        // }
        return $query->getQuery()
            ->execute();
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

            ->andWhere("a.statut = :status")
            ->setParameter('status', $this->statusRepo->getStatusFromName(StatutEchange::open))

            ->getQuery()
            ->getResult();
    }

    // public function alphabetOrder()
    // {
    //     return $this->createQueryBuilder('a')
    //         ->orderBy('a.titre', 'ASC')
    //         ->getQuery()
    //         ->getResult();
    // }

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
