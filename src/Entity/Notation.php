<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\NotationRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=NotationRepository::class)
 * @ApiResource(
 *      attributes={
 *         "security"="is_granted('ROLE_CHEF_DEPARTEMENT')"
 *     },
 *      normalizationContext={"groups"={"read_nota"}}
 * )
 */
class Notation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_nota", "read_comp"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read_nota",  "read_comp"})
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="notations")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_nota"})
     */
    private $competence;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="notations")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_nota"})
     */
    private $utilisateur;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"read_nota"})
     */
    private $periode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): self
    {
        $this->competence = $competence;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getPeriode(): ?\DateTimeInterface
    {
        return $this->periode;
    }

    public function setPeriode(?\DateTimeInterface $periode): self
    {
        $this->periode = $periode;

        return $this;
    }
}
