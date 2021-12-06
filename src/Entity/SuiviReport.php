<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SuiviReportRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SuiviReportRepository::class)
 * @ApiResource(
 *     attributes={
 *         "security"="is_granted('ROLE_CHEF_DEPARTEMENT') || is_granted('ROLE_CHEF_SERVICE')"
 *     },normalizationContext={"groups"={"read_suiviReport"}}
 * )
 */
class SuiviReport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_suiviReport","read_ent"})
     */
    private $id;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"read_suiviReport"})
     */
    private $reportRecu = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"read_suiviReport"})
     */
    private $reportValide = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"read_suiviReport"})
     */
    private $reportRejete = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"read_suiviReport"})
     */
    private $reportInstance = [];

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read_suiviReport"})
     */
    private $solde;

    /**
     * @ORM\ManyToOne(targetEntity=Entite::class, inversedBy="suiviReports")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_suiviReport"})
     */
    private $entite;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $creatadAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    public function __construct()
    {
        $this->creatadAt = new DateTimeImmutable('now');
        $this->status = true;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReportRecu(): ?array
    {
        return $this->reportRecu;
    }

    public function setReportRecu(?array $reportRecu): self
    {
        $this->reportRecu = $reportRecu;

        return $this;
    }

    public function getReportValide(): ?array
    {
        return $this->reportValide;
    }

    public function setReportValide(?array $reportValide): self
    {
        $this->reportValide = $reportValide;

        return $this;
    }

    public function getReportRejete(): ?array
    {
        return $this->reportRejete;
    }

    public function setReportRejete(?array $reportRejete): self
    {
        $this->reportRejete = $reportRejete;

        return $this;
    }

    public function getReportInstance(): ?array
    {
        return $this->reportInstance;
    }

    public function setReportInstance(?array $reportInstance): self
    {
        $this->reportInstance = $reportInstance;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

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

    public function getCreatadAt(): ?DateTimeImmutable
    {
        return $this->creatadAt;
    }

    public function setCreatadAt(DateTimeImmutable $creatadAt): self
    {
        $this->creatadAt = $creatadAt;

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
}
