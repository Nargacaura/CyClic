<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function getUserRating(int $userID): ?int
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql =
            "SELECT 
                AVG(
                    CASE 
                        WHEN t.donneur_id = :user THEN t.note_receveur
                        WHEN t.receveur_id = :user THEN t.note_donneur
                    END
                ) AS average
            FROM transaction AS t
            ";

        $result = $conn
            ->prepare($sql)
            ->executeQuery([
                'user' => $userID
            ])
            ->fetchAssociative();

        $value = $result["average"];
        return $value;
    }
}
