<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="donnations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $donneur;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="recuperations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $receveur;

    /**
     * @ORM\OneToOne(targetEntity=Annonce::class, inversedBy="transaction", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $annonce;

    /**
     * @ORM\Column(type="boolean")
     */
    private $validationDonneur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $validationReceveur;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Range(min = 1, max = 5);
     */
    private $noteDonneur;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Range(min = 1, max = 5);
     */
    private $noteReceveur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDonneur(): ?User
    {
        return $this->donneur;
    }

    public function setDonneur(?User $donneur): self
    {
        $this->donneur = $donneur;

        return $this;
    }

    public function getReceveur(): ?User
    {
        return $this->receveur;
    }

    public function setReceveur(?User $receveur): self
    {
        $this->receveur = $receveur;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

    public function getValidationDonneur(): ?bool
    {
        return $this->validationDonneur;
    }

    public function setValidationDonneur(bool $validationDonneur): self
    {
        $this->validationDonneur = $validationDonneur;

        return $this;
    }

    public function getValidationReceveur(): ?bool
    {
        return $this->validationReceveur;
    }

    public function setValidationReceveur(bool $validationReceveur): self
    {
        $this->validationReceveur = $validationReceveur;

        return $this;
    }

    public function getNoteDonneur(): ?int
    {
        return $this->noteDonneur;
    }

    public function setNoteDonneur(?int $noteDonneur): self
    {
        $this->noteDonneur = $noteDonneur;

        return $this;
    }

    public function getNoteReceveur(): ?int
    {
        return $this->noteReceveur;
    }

    public function setNoteReceveur(?int $noteReceveur): self
    {
        $this->noteReceveur = $noteReceveur;

        return $this;
    }
}
