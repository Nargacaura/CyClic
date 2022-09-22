<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity("email", message="Désolé, vous ne pouvez pas utiliser le même mail pour 2 comptes différents.")
 * @UniqueEntity("pseudo", message="Ce nom d'utilisateur est déjà attribué.")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(message="Désolé, cet e-mail est invalide.")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\OneToMany(targetEntity=Localisation::class, mappedBy="userLocalisation", orphanRemoval=true, cascade={"remove", "persist"})
     */
    private $locUser;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="auteur", orphanRemoval=true, cascade={"remove"})
     */
    private $annonces;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="raters")
     */
    private $note;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="note", cascade={"remove"})
     */
    private $raters;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="expediteur", cascade={"remove"})
     */
    private $envois;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="destinataire", cascade={"remove"})
     */
    private $receptions;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ban;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="donneur")
     */
    private $donnations;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="receveur")
     */
    private $recuperations;

    /**
     * @ORM\OneToOne(targetEntity=Avatar::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity=Signalement::class, mappedBy="auteur")
     */
    private $signalements;
    /**
     * @ORM\Column(type="decimal", precision=2, scale=1, nullable=true)
     */
    private $noteMoyenneUser;

    public function __construct()
    {
        $this->locUser = new ArrayCollection();
        $this->annonces = new ArrayCollection();
        $this->envois = new ArrayCollection();
        $this->receptions = new ArrayCollection();
        $this->ban = 0;
        $this->donnations = new ArrayCollection();
        $this->recuperations = new ArrayCollection();
        $this->signalements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function __toString() {
        return (string) $this->getPseudo();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return Collection|Localisation[]
     */
    public function getLocUser(): Collection
    {
        return $this->locUser;
    }

    public function addLocUser(Localisation $locUser): self
    {
        if (!$this->locUser->contains($locUser)) {
            $this->locUser[] = $locUser;
            $locUser->setUserLocalisation($this);
        }

        return $this;
    }

    public function removeLocUser(Localisation $locUser): self
    {
        if ($this->locUser->removeElement($locUser)) {
            // set the owning side to null (unless already changed)
            if ($locUser->getUserLocalisation() === $this) {
                $locUser->setUserLocalisation(null);
            }
        }

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
            $annonce->setAuteur($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getAuteur() === $this) {
                $annonce->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getEnvois(): Collection
    {
        return $this->envois;
    }

    public function addEnvoi(Message $envoi): self
    {
        if (!$this->envois->contains($envoi)) {
            $this->envois[] = $envoi;
            $envoi->setExpediteur($this);
        }

        return $this;
    }

    public function removeEnvoi(Message $envoi): self
    {
        if ($this->envois->removeElement($envoi)) {
            // set the owning side to null (unless already changed)
            if ($envoi->getExpediteur() === $this) {
                $envoi->setExpediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getReceptions(): Collection
    {
        return $this->receptions;
    }

    public function addReception(Message $reception): self
    {
        if (!$this->receptions->contains($reception)) {
            $this->receptions[] = $reception;
            $reception->setDestinataire($this);
        }

        return $this;
    }

    public function removeReception(Message $reception): self
    {
        if ($this->receptions->removeElement($reception)) {
            // set the owning side to null (unless already changed)
            if ($reception->getDestinataire() === $this) {
                $reception->setDestinataire(null);
            }
        }

        return $this;
    }

    public function getBan(): ?bool
    {
        return $this->ban;
    }

    public function setBan(bool $ban): self
    {
        $this->ban = $ban;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getDonnations(): Collection
    {
        return $this->donnations;
    }

    public function addDonnation(Transaction $donnation): self
    {
        if (!$this->donnations->contains($donnation)) {
            $this->donnations[] = $donnation;
            $donnation->setDonneur($this);
        }

        return $this;
    }

    public function removeDonnation(Transaction $donnation): self
    {
        if ($this->donnations->removeElement($donnation)) {
            // set the owning side to null (unless already changed)
            if ($donnation->getDonneur() === $this) {
                $donnation->setDonneur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getRecuperations(): Collection
    {
        return $this->recuperations;
    }

    public function addRecuperation(Transaction $recuperation): self
    {
        if (!$this->recuperations->contains($recuperation)) {
            $this->recuperations[] = $recuperation;
            $recuperation->setReceveur($this);
        }

        return $this;
    }

    public function removeRecuperation(Transaction $recuperation): self
    {
        if ($this->recuperations->removeElement($recuperation)) {
            // set the owning side to null (unless already changed)
            if ($recuperation->getReceveur() === $this) {
                $recuperation->setReceveur(null);
            }
        }

        return $this;
    }

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function setAvatar(Avatar $avatar): self
    {
        // set the owning side of the relation if necessary
        if ($avatar->getUser() !== $this) {
            $avatar->setUser($this);
        }

        $this->avatar = $avatar;

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
            $signalement->setAuteur($this);
        }

        return $this;
    }

    public function removeSignalement(Signalement $signalement): self
    {
        if ($this->signalements->removeElement($signalement)) {
            // set the owning side to null (unless already changed)
            if ($signalement->getAuteur() === $this) {
                $signalement->setAuteur(null);
            }
        }
        return $this;
    }
    public function getNoteMoyenneUser(): ?string
    {
        return $this->noteMoyenneUser;
    }

    public function setNoteMoyenneUser(?string $noteMoyenneUser): self
    {
        $this->noteMoyenneUser = $noteMoyenneUser;

        return $this;
    }
}
