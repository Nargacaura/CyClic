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

    private $indexed;

    public function getStatusFromName(string $nom): StatutEchange
    {
        if ($this->indexed) return $this->indexed[$nom];
        $allstatus = $this->findAll();
        foreach ($allstatus as $value) {
            $this->indexed[$value->getNom()] = $value;
        }
        return $this->indexed[$nom];
    }
}
