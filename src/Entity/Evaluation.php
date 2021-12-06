<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EvaluationRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EvaluationRepository::class)
 * @ApiResource(
 *     attributes={
 *         "security"="is_granted('ROLE_CHEF_DEPARTEMENT') || is_granted('ROLE_CHEF_SERVICE')"
 *     },
 *      normalizationContext = {"groups"={"read_eval"}}
 * )
 */
class Evaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     * @Groups({"read_eval"})
     */
    private $libelle = [];

    /**
     * @ORM\Column(type="array")
     * @Groups({"read_eval"})
     */
    private $evaluation = [];

    /**
     * @ORM\Column(type="array")
     * @Groups({"read_eval"})
     */
    private $commentaireAudManager = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"read_eval"})
     */
    private $commentaireAud = [];

    /**
     * @ORM\OneToOne(targetEntity=Mission::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_eval"})
     */
    private $mission;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?array
    {
        return $this->libelle;
    }

    public function setLibelle(array $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getEvaluation(): ?array
    {
        return $this->evaluation;
    }

    public function setEvaluation(array $evaluation): self
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    public function getCommentaireAudManager(): ?array
    {
        return $this->commentaireAudManager;
    }

    public function setCommentaireAudManager(array $commentaireAudManager): self
    {
        $this->commentaireAudManager = $commentaireAudManager;

        return $this;
    }

    public function getCommentaireAud(): ?array
    {
        return $this->commentaireAud;
    }

    public function setCommentaireAud(?array $commentaireAud): self
    {
        $this->commentaireAud = $commentaireAud;

        return $this;
    }

    public function getMission(): ?Mission
    {
        return $this->mission;
    }

    public function setMission(Mission $mission): self
    {
        $this->mission = $mission;

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

}
