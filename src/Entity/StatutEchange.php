<?php

namespace App\Entity;

use App\Repository\StatutEchangeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatutEchangeRepository::class)
 */
class StatutEchange
{

    public const open = "Ouvert";
    public const cancelled = "Annulé";
    public const inValidation = "ValidationEchange";
    public const validated = "EchangeValidé";
    public const close = "Fini";

    public const status = array(
        "Ouvert",
        "Annulé",
        "ValidationEchange",
        "EchangeValidé",
        "Fini",
    );


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="statut")
     */
    private $annonces;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setStatut($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getStatut() === $this) {
                $annonce->setStatut(null);
            }
        }

        return $this;
    }
}
