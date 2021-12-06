<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DepartementRepository::class)
 * @ApiResource(
 *   attributes={
 *         "security"="is_granted('ROLE_ADMIN')"
 *     },normalizationContext={"groups"={"read_dept"}},
 * )
 */
class Departement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_user", "read_dept", "read_ent"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_user", "read_dept", "read_ent"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read_dept"})
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, mappedBy="departement", orphanRemoval=true)
     *  @Groups({"read_dept"})
     */
    private $utilisateurs;

    /**
     * @ORM\OneToOne(targetEntity=Utilisateur::class, cascade={"persist", "remove"})
     *  @Groups({"read_dept"})
     */
    private $responsable;

    /**
     * @ORM\OneToMany(targetEntity=Entite::class, mappedBy="departement", orphanRemoval=true)
     *  @Groups({"read_dept"})
     */
    private $entites;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->entites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
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

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->setDepartement($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getDepartement() === $this) {
                $utilisateur->setDepartement(null);
            }
        }

        return $this;
    }

    public function getResponsable(): ?Utilisateur
    {
        return $this->responsable;
    }

    public function setResponsable(?Utilisateur $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * @return Collection|Entite[]
     */
    public function getEntites(): Collection
    {
        return $this->entites;
    }

    public function addEntite(Entite $entite): self
    {
        if (!$this->entites->contains($entite)) {
            $this->entites[] = $entite;
            $entite->setDepartement($this);
        }

        return $this;
    }

    public function removeEntite(Entite $entite): self
    {
        if ($this->entites->removeElement($entite)) {
            // set the owning side to null (unless already changed)
            if ($entite->getDepartement() === $this) {
                $entite->setDepartement(null);
            }
        }

        return $this;
    }
}
