<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $titre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datePublication;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auteur;

    /**
     * @ORM\ManyToOne(targetEntity=Localisation::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $localisation;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="annonce", orphanRemoval=true, cascade={"persist"})
     */
    private $photos;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=StatutEchange::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="annonce", orphanRemoval=true)
     */
    private $messages;

    /**
     * @ORM\OneToOne(targetEntity=Transaction::class, mappedBy="annonce", cascade={"persist"})
     */
    private $transaction;

    /**
     * @ORM\OneToMany(targetEntity=CalendarData::class, mappedBy="annonce", orphanRemoval=true)
     */
    private $calendar;

    /**
     * @ORM\OneToMany(targetEntity=Signalement::class, mappedBy="annonce", cascade={"remove"})
     */
    private $signalements;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->calendar = new ArrayCollection();
        $this->signalements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getLocalisation(): ?Localisation
    {
        return $this->localisation;
    }

    public function setLocalisation(?Localisation $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setAnnonce($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getAnnonce() === $this) {
                $photo->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getStatut(): ?StatutEchange
    {
        return $this->statut;
    }

    public function setStatut(?StatutEchange $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setAnnonce($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getAnnonce() === $this) {
                $message->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(Transaction $transaction): self
    {
        // set the owning side of the relation if necessary
        if ($transaction->getAnnonce() !== $this) {
            $transaction->setAnnonce($this);
        }

        $this->transaction = $transaction;

        return $this;
    }

    /**
     * @return Collection|CalendarData[]
     */
    public function getCalendar(): Collection
    {
        return $this->calendar;
    }

    public function addCalendar(CalendarData $calendar): self
    {
        if (!$this->calendar->contains($calendar)) {
            $this->calendar[] = $calendar;
            $calendar->setAnnonce($this);
        }

        return $this;
    }

    public function removeCalendar(CalendarData $calendar): self
    {
        if ($this->calendar->removeElement($calendar)) {
            // set the owning side to null (unless already changed)
            if ($calendar->getAnnonce() === $this) {
                $calendar->setAnnonce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Signalement>
     */
    public function getSignalements(): Collection
    {
        return $this->signalements;
    }

    public function addSignalement(Signalement $signalement): self
    {
        if (!$this->signalements->contains($signalement)) {
            $this->signalements[] = $signalement;
            $signalement->setAnnonce($this);
        }

        return $this;
    }

    public function removeSignalement(Signalement $signalement): self
    {
        if ($this->signalements->removeElement($signalement)) {
            // set the owning side to null (unless already changed)
            if ($signalement->getAnnonce() === $this) {
                $signalement->setAnnonce(null);
            }
        }

        return $this;
    }
}
