<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReportingCodirRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReportingCodirRepository::class)
 * @ApiResource(
 *     attributes={
 *         "security"="is_granted('ROLE_CHEF_DEPARTEMENT') || is_granted('ROLE_CHEF_SERVICE')"
 *     },normalizationContext={"groups"={"read_reportingcodir"}}
 * )
 */
class ReportingCodir
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_ent", "read_reportingcodir"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_reportingcodir"})
     */
    private $semaine;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read_reportingcodir"})
     */
    private $fonctionne;

    /**
     * @ORM\Column(type="text")
     *  @Groups({"read_reportingcodir"})
     */
    private $pointCoordination;

    /**
     * @ORM\Column(type="text", nullable=true)
     *  @Groups({"read_reportingcodir"})
     */
    private $difficultes;

    /**
     * @ORM\ManyToOne(targetEntity=Entite::class, inversedBy="reportingCodirs")
     * @ORM\JoinColumn(nullable=false)
     *  @Groups({"read_reportingcodir"})
     */
    private $entite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSemaine(): ?string
    {
        return $this->semaine;
    }

    public function setSemaine(string $semaine): self
    {
        $this->semaine = $semaine;

        return $this;
    }

    public function getFonctionne(): ?string
    {
        return $this->fonctionne;
    }

    public function setFonctionne(string $fonctionne): self
    {
        $this->fonctionne = $fonctionne;

        return $this;
    }

    public function getPointCoordination(): ?string
    {
        return $this->pointCoordination;
    }

    public function setPointCoordination(string $pointCoordination): self
    {
        $this->pointCoordination = $pointCoordination;

        return $this;
    }

    public function getDifficultes(): ?string
    {
        return $this->difficultes;
    }

    public function setDifficultes(?string $difficultes): self
    {
        $this->difficultes = $difficultes;

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
}
