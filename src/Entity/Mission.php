<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MissionRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MissionRepository::class)
 * @ApiResource(
 *     attributes={
 *         "security"="is_granted('ROLE_CHEF_DEPARTEMENT') || is_granted('ROLE_CHEF_SERVICE') || is_granted('ROLE_AUDITEUR')"
 *     },
 *      normalizationContext={"groups"={"read_miss"}}
 * )
 */
class Mission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_miss","read_ent","read_rapp","read_eval", "read_suivi_activite"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_miss", "read_ent","read_rapp","read_eval", "read_suivi_activite"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_miss"})
     */
    private $annee;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"read_miss"})
     */
    private $debutAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"read_miss"})
     */
    private $finAt;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read_miss"})
     */
    private $nbreJrReel;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"read_miss"})
     */
    private $nbreJrPrevu;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_miss"})
     */
    private $responsable;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, inversedBy="missions")
     * @Groups({"read_miss"})
     */
    private $utilisateurs;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"read_miss"})
     */
    private $impact;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"read_miss"})
     */
    private $gravite;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"read_miss"})
     */
    private $tauxCimTeste;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"read_miss"})
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Entite::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_miss"})
     */
    private $entite;

    /**
     * @ORM\OneToMany(targetEntity=SuiviActivite::class, mappedBy="mission", orphanRemoval=true)
     * @Groups({"read_miss"})
     */
    private $suiviActivites;

    /**
     * @ORM\OneToMany(targetEntity=Rapport::class, mappedBy="mission", orphanRemoval=true)
     * @Groups({"read_miss"})
     */
    private $rapports;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read_miss"})
     */
    private $status;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->suiviActivites = new ArrayCollection();
        $this->rapports = new ArrayCollection();
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

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getDebutAt(): ?\DateTimeImmutable
    {
        return $this->debutAt;
    }

    public function setDebutAt(\DateTimeImmutable $debutAt): self
    {
        $this->debutAt = $debutAt;

        return $this;
    }

    public function getFinAt(): ?\DateTimeImmutable
    {
        return $this->finAt;
    }

    public function setFinAt(?\DateTimeImmutable $finAt): self
    {
        $this->finAt = $finAt;

        return $this;
    }

    public function getNbreJrReel(): ?int
    {
        return $this->nbreJrReel;
    }

    public function setNbreJrReel(int $nbreJrReel): self
    {
        $this->nbreJrReel = $nbreJrReel;

        return $this;
    }

    public function getNbreJrPrevu(): ?int
    {
        return $this->nbreJrPrevu;
    }

    public function setNbreJrPrevu(?int $nbreJrPrevu): self
    {
        $this->nbreJrPrevu = $nbreJrPrevu;

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
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateurs->removeElement($utilisateur);

        return $this;
    }

    public function getImpact(): ?int
    {
        return $this->impact;
    }

    public function setImpact(?int $impact): self
    {
        $this->impact = $impact;

        return $this;
    }

    public function getGravite(): ?int
    {
        return $this->gravite;
    }

    public function setGravite(?int $gravite): self
    {
        $this->gravite = $gravite;

        return $this;
    }

    public function getTauxCimTeste(): ?float
    {
        return $this->tauxCimTeste;
    }

    public function setTauxCimTeste(?float $tauxCimTeste): self
    {
        $this->tauxCimTeste = $tauxCimTeste;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

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

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
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
            $suiviActivite->setMission($this);
        }

        return $this;
    }

    public function removeSuiviActivite(SuiviActivite $suiviActivite): self
    {
        if ($this->suiviActivites->removeElement($suiviActivite)) {
            // set the owning side to null (unless already changed)
            if ($suiviActivite->getMission() === $this) {
                $suiviActivite->setMission(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rapport[]
     */
    public function getRapports(): Collection
    {
        return $this->rapports;
    }

    public function addRapport(Rapport $rapport): self
    {
        if (!$this->rapports->contains($rapport)) {
            $this->rapports[] = $rapport;
            $rapport->setMission($this);
        }

        return $this;
    }

    public function removeRapport(Rapport $rapport): self
    {
        if ($this->rapports->removeElement($rapport)) {
            // set the owning side to null (unless already changed)
            if ($rapport->getMission() === $this) {
                $rapport->setMission(null);
            }
        }

        return $this;
    }
}
