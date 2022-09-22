<?php

namespace App\Repository;

use App\Entity\CalendarData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CalendarData|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalendarData|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalendarData[]    findAll()
 * @method CalendarData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendarDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalendarData::class);
    }

    /**
     * Les info du calendrier relatif à l'annonce partager avec l'autre utilisateur
     * @var int $userId l'id de l'utilisateur 
     * @var int $otherId l'id du l'autre utilisateur 
     * @var int $annonceId l'id de l'annonce
     */
    public function calendrierUserAnnonce(int $userId, int $otherId, int $annonceId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 
            "SELECT c.*
            FROM calendar_data AS c
            WHERE c.annonce_id = :annonce
            AND ((c.detenteur_id = :user AND c.destinataire_id  = :other)
            OR (c.detenteur_id = :other AND c.destinataire_id  = :user))"
            ;

        return $conn
            ->prepare($sql)
            ->executeQuery([
                'annonce' => $annonceId,
                'user' => $userId,
                'other' => $otherId,
                ])
            ->fetchAllAssociative();
        /*
         version pour avoir l'entity mais ne permet pas de faire un json_encode
         */
        // $manager = $this->getEntityManager();
        // $rsm = new ResultSetMappingBuilder($manager);
        // $rsm->addRootEntityFromClassMetadata(CalendarData::class, 'c');

        // $query = $manager->createNativeQuery(
        //     "SELECT c.titre, c.description
        //     FROM calendar_data AS c
        //     WHERE c.annonce_id = :annonce
        //     AND ((c.detenteur_id = :user AND c.destinataire_id  = :other)
        //     OR (c.detenteur_id = :other AND c.destinataire_id  = :user))",
        //     $rsm
        // );
        // $query->setParameters([
        //     'annonce' => $annonceId,
        //     'user' => $userId,
        //     'other' => $otherId,
        // ]);
        // return $query->getResult();
        
    }

}
