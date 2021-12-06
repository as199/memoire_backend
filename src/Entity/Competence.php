<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 * @ApiResource(
 *     attributes={
 *         "security"="is_granted('ROLE_CHEF_DEPARTEMENT') || is_granted('ROLE_CHEF_SERVICE')"
 *     },
 *     normalizationContext={"groups"={"read_comp"}},
 * )
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_comp", "read_them", "read_nota", "read_nota"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_comp", "read_them", "read_nota", "read_nota"})})
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=Thematique::class, inversedBy="competences")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_comp"})
     */
    private $thematique;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read_comp"})
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read_comp"})
     */
    private $compCnceIt;

    /**
     * @ORM\OneToMany(targetEntity=Notation::class, mappedBy="competence", orphanRemoval=true)
     * @Groups({"read_comp"})
     */
    private $notations;

    public function __construct()
    {
        $this->notations = new ArrayCollection();
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

    public function getThematique(): ?Thematique
    {
        return $this->thematique;
    }

    public function setThematique(?Thematique $thematique): self
    {
        $this->thematique = $thematique;

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

    public function getCompCnceIt(): ?string
    {
        return $this->compCnceIt;
    }

    public function setCompCnceIt(?string $compCnceIt): self
    {
        $this->compCnceIt = $compCnceIt;

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
            $notation->setCompetence($this);
        }

        return $this;
    }

    public function removeNotation(Notation $notation): self
    {
        if ($this->notations->removeElement($notation)) {
            // set the owning side to null (unless already changed)
            if ($notation->getCompetence() === $this) {
                $notation->setCompetence(null);
            }
        }

        return $this;
    }
}
