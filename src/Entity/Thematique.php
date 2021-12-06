<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ThematiqueRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ThematiqueRepository::class)
 * @ApiResource(
 *     attributes={
 *         "security"="is_granted('ROLE_CHEF_DEPARTEMENT') || is_granted('ROLE_CHEF_SERVICE')"
 *     },
 *      normalizationContext={"groups"={"read_them"}}
 * )
 */
class Thematique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_them","read_comp"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_them","read_comp"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read_them"})
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Competence::class, mappedBy="thematique", orphanRemoval=true)
     * @Groups({"read_them"})
     */
    private $competences;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
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
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
            $competence->setThematique($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->removeElement($competence)) {
            // set the owning side to null (unless already changed)
            if ($competence->getThematique() === $this) {
                $competence->setThematique(null);
            }
        }

        return $this;
    }
}
