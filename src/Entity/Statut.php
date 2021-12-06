<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\StatutRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=StatutRepository::class)
 * @ApiResource(
 *      attributes={
 *         "security"="is_granted('ROLE_CHEF_DEPARTEMENT')"
 *     },
 *       normalizationContext={"groups"={"read_stats"}}
 * )
 */
class Statut
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_stats", "read_suivi_activite"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_stats", "read_suivi_activite"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read_stats"})
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=SuiviActivite::class, mappedBy="statut", orphanRemoval=true)
     * @Groups({"read_stats"})
     * 
     */
    private $suiviActivites;

    public function __construct()
    {
        $this->suiviActivites = new ArrayCollection();
        $this->status = true;
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
     * @return Collection|SuiviActivite[]
     */
    public function getSuiviActivites(): Collection
    {
        return $this->suiviActivites;
    }

    public function addSuiviActivite(SuiviActivite $suiviActivite): self
    {
        if (!$this->suiviActivites->contains($suiviActivite)) {
            $this->suiviActivites[] = $suiviActivite;
            $suiviActivite->setStatut($this);
        }

        return $this;
    }

    public function removeSuiviActivite(SuiviActivite $suiviActivite): self
    {
        if ($this->suiviActivites->removeElement($suiviActivite)) {
            // set the owning side to null (unless already changed)
            if ($suiviActivite->getStatut() === $this) {
                $suiviActivite->setStatut(null);
            }
        }

        return $this;
    }
}
