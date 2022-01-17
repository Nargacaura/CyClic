<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
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
     * @ORM\OneToMany(targetEntity=Localisation::class, mappedBy="userLocalisation", orphanRemoval=true)
     */
    private $locUser;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="auteur", orphanRemoval=true)
     */
    private $annonces;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="raters")
     */
    private $note;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="note")
     */
    private $raters;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="expediteur")
     */
    private $envois;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="destinataire")
     */
    private $receptions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    public function __construct()
    {
        $this->locUser = new ArrayCollection();
        $this->annonces = new ArrayCollection();
        $this->note = new ArrayCollection();
        $this->raters = new ArrayCollection();
        $this->envois = new ArrayCollection();
        $this->receptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|self[]
     */
    public function getNote(): Collection
    {
        return $this->note;
    }

    public function addNote(self $note): self
    {
        if (!$this->note->contains($note)) {
            $this->note[] = $note;
        }

        return $this;
    }

    public function removeNote(self $note): self
    {
        $this->note->removeElement($note);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getRaters(): Collection
    {
        return $this->raters;
    }

    public function addRater(self $rater): self
    {
        if (!$this->raters->contains($rater)) {
            $this->raters[] = $rater;
            $rater->addNote($this);
        }

        return $this;
    }

    public function removeRater(self $rater): self
    {
        if ($this->raters->removeElement($rater)) {
            $rater->removeNote($this);
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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
}
