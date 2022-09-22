<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Localisation;
use App\Entity\StatutEchange;
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

    public function searchAnnonceSimple($search, $limit = 20)
    {
        $query = $this->createQueryBuilder("a");
        if ($search != null) {
            if ($search["titre"]) {
                $query->andWhere("a.contenu LIKE :text")
                    ->andWhere("a.titre LIKE :text OR a.contenu LIKE :text")
                    ->setParameters(array(
                        "text" => "%" . $search["titre"] . "%"
                    ));
            }
            if ($search["categorie"]) {
                $query->andWhere("a.categorie = :idCat")
                    ->setParameter("idCat", $search["categorie"]);
            }
        }
        $query->andWhere("a.statut = :status")
            ->setParameter('status', $this->statusRepo->getStatusFromName(StatutEchange::open));
        $query->setMaxResults($limit);
        return $query->getQuery()
            ->execute();
    }

    public function searchAnnonceComplete($request, $lat, $lng, $allStatus = false, $limit = 20)
    {
        $query = $this->createQueryBuilder("a");
        if ($request->get("categorie")) {
            $query->andWhere("a.categorie = :idCat")
                ->setParameter("idCat", $request->get("categorie"));
        }
        if ($request->get("etat")) {
            $query->andWhere("a.etat = :idEtat")
                ->setParameter("idEtat", $request->get("etat"));
        }
        if ($request->get("titre")) {
            $query->andWhere("a.titre LIKE :text OR a.contenu LIKE :text")
                ->setParameter("text", "%" . $request->get("titre") . "%");
        }
        if ($request->get("radius")) {
            $query->join("a.localisation", "l");
            $haversineFormula = "( 6371 * acos( cos( radians(" . $lat . ")) * cos( radians( l.latitude ) ) 
                * cos( radians( l.longitude ) - radians(" . $lng . ") ) + sin( radians(" . $lat . ") ) * sin(radians(l.latitude)) )  <= :radius)";
            $query->andWhere($haversineFormula);
            $query->setParameter('radius', $request->get("radius"));
        }
        switch ($request->get("tri")) {
            case 1:
                $query->orderBy('a.datePublication', 'ASC');
                break;
            case 2:
                $query->orderBy('a.titre', 'ASC');
                break;
            case 3:
                $query->join("a.auteur", "u");
                $query->orderby('u.noteMoyenneUser', 'DESC');
                break;
            default:
                $query->orderBy('a.datePublication', 'DESC');
        }
        $query->setMaxResults($limit);
        return $query->getQuery()
            ->execute();
    }

    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */

    public function searchAnnonce($search, $limit = 20)
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

            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
