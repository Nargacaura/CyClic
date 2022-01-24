<?php

namespace App\Entity\DoctrineMigrations;

use App\Repository\DoctrineMigrations\Version20220121141818Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=Version20220121141818Repository::class)
 */
class Version20220121141818
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
