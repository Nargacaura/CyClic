<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    /**
     * Les messages relatifs à une annonce de l'utilisateur connecté où il est donneur, triés par date.
     * @var int $fromId l'id du l'utilisateur receveur
     * @var int $userAnnonceId l'id de l'annonce
     */
    public function messageFromUserAnnonce(int $fromId, int $userAnnonceId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql =
            "SELECT m.contenu, a.titre, m.date, m.expediteur_id, m.destinataire_id, a.id FROM message AS m
            INNER JOIN annonce AS a
                ON m.annonce_id = a.id
            WHERE a.id = :annonce
            AND (m.expediteur_id = :user OR m.destinataire_id  = :user)
            ORDER BY m.date";

        return $conn
            ->prepare($sql)
            ->executeQuery([
                'user' => $fromId,
                'annonce' => $userAnnonceId
            ])
            ->fetchAllAssociative();
    }

    /**
     * Les messages relatifs à une annonce où l'utilisateur connecté est le receveur, triés par date.
     * @var int $userId l'id de l'utilisateur
     * @var int $userAnnonceId l'id de l'annonce
     */
    public function messageToAnnonce(int $userId, int $userAnnonceId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql =
            "SELECT m.* FROM message AS m
            INNER JOIN annonce AS a
                ON m.annonce_id = a.id
            INNER JOIN user AS u
                ON u.id = a.auteur_id
            WHERE a.id = :annonce
            AND (m.expediteur_id = :user OR m.destinataire_id = :user)
            ORDER BY m.date";

        return $conn
            ->prepare($sql)
            ->executeQuery([
                'user' => $userId,
                'annonce' => $userAnnonceId
            ])
            ->fetchAllAssociative();
    }

    /**
     * Trouve les annonces où l'utilisateur à envoyé un message, triés par date.
     * @var int $userId l'id de l'utilisateur
     * @return // des infos sur l'annonce et les messages trouvés
     */
    public function findOtherAnnonceSendedMessage(int $userId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql =
            "SELECT m.contenu, a.titre, m.date, m.expediteur_id, m.destinataire_id, a.id, u.pseudo FROM message AS m
            INNER JOIN annonce AS a
                ON m.annonce_id = a.id
            INNER JOIN user AS u
                ON u.id = a.auteur_id
            WHERE a.auteur_id != :user
            AND (m.expediteur_id = :user OR m.destinataire_id = :user)
            ORDER BY m.date";

        return $conn
            ->prepare($sql)
            ->executeQuery([
                'user' => $userId
            ])
            ->fetchAllAssociative();
    }
}
