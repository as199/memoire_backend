<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RapportRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=RapportRepository::class)
 * @ApiResource(
 *     attributes={
 *         "security"="is_granted('ROLE_CHEF_DEPARTEMENT') || is_granted('ROLE_CHEF_SERVICE')"
 *     },
 *      normalizationContext={"groups"={"read_rapp"}}
 * )
 */
class Rapport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_rapp", "read_miss"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_rapp"})
     */
    private $constats;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_rapp"})
     */
    private $causes;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"read_rapp"})
     */
    private $recommandation;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"read_rapp"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Mission::class, inversedBy="rapports")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_rapp"})
     */
    private $mission;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read_rapp"})
     */
    private $status;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"read_rapp"})
     */
    private $rapport;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable('now');
        $this->status = true;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConstats(): ?string
    {
        return $this->constats;
    }

    public function setConstats(string $constats): self
    {
        $this->constats = $constats;

        return $this;
    }

    public function getCauses(): ?string
    {
        return $this->causes;
    }

    public function setCauses(string $causes): self
    {
        $this->causes = $causes;

        return $this;
    }

    public function getRecommandation(): ?string
    {
        return $this->recommandation;
    }

    public function setRecommandation(?string $recommandation): self
    {
        $this->recommandation = $recommandation;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getRapport(): string
    {
        return ($this->rapport !== null )? base64_encode(stream_get_contents($this->rapport)):$this->rapport;
    }

    public function setRapport($rapport): self
    {
        $this->rapport = $rapport;

        return $this;
    }
}
