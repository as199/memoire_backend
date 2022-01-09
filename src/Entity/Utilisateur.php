<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 ** @ApiResource(
 *     attributes={
 *         "security"="is_granted('ROLE_ADMIN') || is_granted('ROLE_CHEF_DEPARTEMENT') || is_granted('ROLE_CHEF_SERVICE')|| is_granted('ROLE_AUDITEUR')"
 *     },
 *   normalizationContext={"groups"={"read_user"}}
 * )
 */
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_user","read_diplom", "read_fonc","read_ent","read_miss", "read_dept", "read_nota"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"read_user", "read_miss"})
     */
    private $username;


    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_user","read_diplom", "read_fonc","read_ent", "read_miss", "read_dept","read_nota"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_user","read_diplom", "read_fonc","read_ent", "read_miss", "read_dept","read_nota"})
     */
    private $nom;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read_user"})
     */
    private $status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"read_user"})
     */
    private $nbrJrFormation;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"read_user"})
     */
    private $entreeAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"read_user"})
     */
    private $sortieAt;

    /**
     * @ORM\ManyToOne(targetEntity=Fonction::class, inversedBy="utilisateurs")
     * @Groups({"read_user"})
     */
    private $fonction;

    /**
     * @ORM\ManyToOne(targetEntity=Entite::class, inversedBy="utilisateurs")
     * @Groups({"read_user"})
     */
    private $entite;

    /**
     * @ORM\ManyToOne(targetEntity=Departement::class, inversedBy="utilisateurs")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_user"})
     */
    private $departement;

    /**
     * @ORM\OneToMany(targetEntity=Notation::class, mappedBy="utilisateur", orphanRemoval=true)
     */
    private $notations;

    /**
     * @ORM\ManyToMany(targetEntity=Mission::class, mappedBy="utilisateurs")
     * @Groups({"read_user"})
     */
    private $missions;

    /**
     * @ORM\OneToMany(targetEntity=Diplome::class, mappedBy="utilisateur", orphanRemoval=true)
     */
    private $diplomes;

    /**
     * @ORM\OneToMany(targetEntity=Certification::class, mappedBy="utilisateur", orphanRemoval=true)
     */
    private $certifications;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read_user","read_diplom", "read_fonc","read_ent", "read_miss", "read_dept","read_nota"})
     */
    private $email;

    public function __construct()
    {
        $this->notations = new ArrayCollection();
        $this->missions = new ArrayCollection();
        $this->diplomes = new ArrayCollection();
        $this->certifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->fonction->getLibelle();

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

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

   

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getNbrJrFormation(): ?int
    {
        return $this->nbrJrFormation;
    }

    public function setNbrJrFormation(?int $nbrJrFormation): self
    {
        $this->nbrJrFormation = $nbrJrFormation;

        return $this;
    }

    public function getEntreeAt(): ?\DateTimeImmutable
    {
        return $this->entreeAt;
    }

    public function setEntreeAt(?\DateTimeImmutable $entreeAt): self
    {
        $this->entreeAt = $entreeAt;

        return $this;
    }

    public function getSortieAt(): ?\DateTimeImmutable
    {
        return $this->sortieAt;
    }

    public function setSortieAt(?\DateTimeImmutable $sortieAt): self
    {
        $this->sortieAt = $sortieAt;

        return $this;
    }

    public function getFonction(): ?Fonction
    {
        return $this->fonction;
    }

    public function setFonction(?Fonction $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getEntite(): ?Entite
    {
        return $this->entite;
    }

    public function setEntite(?Entite $entite): self
    {
        $this->entite = $entite;

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection|Notation[]
     */
    public function getNotations(): Collection
    {
        return $this->notations;
    }

    public function addNotation(Notation $notation): self
    {
        if (!$this->notations->contains($notation)) {
            $this->notations[] = $notation;
            $notation->setUtilisateur($this);
        }

        return $this;
    }

    public function removeNotation(Notation $notation): self
    {
        if ($this->notations->removeElement($notation)) {
            // set the owning side to null (unless already changed)
            if ($notation->getUtilisateur() === $this) {
                $notation->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions[] = $mission;
            $mission->addUtilisateur($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            $mission->removeUtilisateur($this);
        }

        return $this;
    }

    /**
     * @return Collection|Diplome[]
     */
    public function getDiplomes(): Collection
    {
        return $this->diplomes;
    }

    public function addDiplome(Diplome $diplome): self
    {
        if (!$this->diplomes->contains($diplome)) {
            $this->diplomes[] = $diplome;
            $diplome->setUtilisateur($this);
        }

        return $this;
    }

    public function removeDiplome(Diplome $diplome): self
    {
        if ($this->diplomes->removeElement($diplome)) {
            // set the owning side to null (unless already changed)
            if ($diplome->getUtilisateur() === $this) {
                $diplome->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Certification[]
     */
    public function getCertifications(): Collection
    {
        return $this->certifications;
    }

    public function addCertification(Certification $certification): self
    {
        if (!$this->certifications->contains($certification)) {
            $this->certifications[] = $certification;
            $certification->setUtilisateur($this);
        }

        return $this;
    }

    public function removeCertification(Certification $certification): self
    {
        if ($this->certifications->removeElement($certification)) {
            // set the owning side to null (unless already changed)
            if ($certification->getUtilisateur() === $this) {
                $certification->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
