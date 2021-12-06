<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SuiviActiviteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SuiviActiviteRepository::class)
 * @ApiResource(
 *     attributes={
 *         "security"="is_granted('ROLE_CHEF_DEPARTEMENT') || is_granted('ROLE_CHEF_SERVICE')"
 *     },normalizationContext={"groups"={"read_suivi_activite"}}
 * )
 */
class SuiviActivite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_suivi_activite", "read_miss", "read_stats"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_suivi_activite"})
     */
    private $semaine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read_suivi_activite"})
     */
    private $fait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read_suivi_activite"})
     */
    private $resteFaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read_suivi_activite"})
     */
    private $difficultes;

    /**
     * @ORM\ManyToOne(targetEntity=Statut::class, inversedBy="suiviActivites")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_suivi_activite"})
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Mission::class, inversedBy="suiviActivites")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_suivi_activite"})
     */
    private $mission;

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

    public function getFait(): ?string
    {
        return $this->fait;
    }

    public function setFait(?string $fait): self
    {
        $this->fait = $fait;

        return $this;
    }

    public function getResteFaire(): ?string
    {
        return $this->resteFaire;
    }

    public function setResteFaire(?string $resteFaire): self
    {
        $this->resteFaire = $resteFaire;

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

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getMission(): ?Mission
    {
        return $this->mission;
    }

    public function setMission(?Mission $mission): self
    {
        $this->mission = $mission;

        return $this;
    }
}
