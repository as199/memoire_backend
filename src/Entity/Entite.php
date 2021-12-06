<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EntiteRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EntiteRepository::class)
 * @ApiResource(attributes={"security"="is_granted('ROLE_ADMIN') || is_granted('ROLE_CHEF_DEPARTEMENT')"},
 * normalizationContext={"groups"={"read_ent"}}
 * )
 */
class Entite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_ent", "read_user","read_miss", "read_dept","read_suiviReport", "read_reportingcodir"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_ent", "read_user","read_miss", "read_dept","read_suiviReport","read_reportingcodir"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read_ent"})
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, mappedBy="entite")
     * @Groups({"read_ent"})
     */
    private $utilisateurs;

    /**
     * @ORM\OneToOne(targetEntity=Utilisateur::class, cascade={"persist", "remove"})
     * @Groups({"read_ent"})
     */
    private $responsable;

    /**
     * @ORM\OneToMany(targetEntity=Mission::class, mappedBy="entite", orphanRemoval=true)
     * @Groups({"read_ent"})
     */
    private $missions;

    /**
     * @ORM\OneToMany(targetEntity=SuiviReport::class, mappedBy="entite", orphanRemoval=true)
     * @Groups({"read_ent"})
     */
    private $suiviReports;

    /**
     * @ORM\OneToMany(targetEntity=ReportingCodir::class, mappedBy="entite")
     * @Groups({"read_ent"})
     */
    private $reportingCodirs;

    /**
     * @ORM\ManyToOne(targetEntity=Departement::class, inversedBy="entites")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_ent"})
     */
    private $departement;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->missions = new ArrayCollection();
        $this->suiviReports = new ArrayCollection();
        $this->reportingCodirs = new ArrayCollection();
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
            $utilisateur->setEntite($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getEntite() === $this) {
                $utilisateur->setEntite(null);
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
            $mission->setEntite($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getEntite() === $this) {
                $mission->setEntite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SuiviReport[]
     */
    public function getSuiviReports(): Collection
    {
        return $this->suiviReports;
    }

    public function addSuiviReport(SuiviReport $suiviReport): self
    {
        if (!$this->suiviReports->contains($suiviReport)) {
            $this->suiviReports[] = $suiviReport;
            $suiviReport->setEntite($this);
        }

        return $this;
    }

    public function removeSuiviReport(SuiviReport $suiviReport): self
    {
        if ($this->suiviReports->removeElement($suiviReport)) {
            // set the owning side to null (unless already changed)
            if ($suiviReport->getEntite() === $this) {
                $suiviReport->setEntite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ReportingCodir[]
     */
    public function getReportingCodirs(): Collection
    {
        return $this->reportingCodirs;
    }

    public function addReportingCodir(ReportingCodir $reportingCodir): self
    {
        if (!$this->reportingCodirs->contains($reportingCodir)) {
            $this->reportingCodirs[] = $reportingCodir;
            $reportingCodir->setEntite($this);
        }

        return $this;
    }

    public function removeReportingCodir(ReportingCodir $reportingCodir): self
    {
        if ($this->reportingCodirs->removeElement($reportingCodir)) {
            // set the owning side to null (unless already changed)
            if ($reportingCodir->getEntite() === $this) {
                $reportingCodir->setEntite(null);
            }
        }

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
}
