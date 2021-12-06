<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DiplomeRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DiplomeRepository::class)
 * @ApiResource(
 * attributes={
 *         "security"="is_granted('ROLE_CHEF_DEPARTEMENT') || is_granted('ROLE_CHEF_SERVICE') || is_granted('ROLE_AUDITEUR')"
 *     },
 *     normalizationContext={"groups"={"read_diplom"}}
 * )
 */
class Diplome
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_diplom", "read_user"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_diplom", "read_user"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"read_diplom"})
     */
    private $obtenuAt;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="diplomes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_diplom"})
     */
    private $utilisateur;

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

    public function getObtenuAt(): ?\DateTimeImmutable
    {
        return $this->obtenuAt;
    }

    public function setObtenuAt(\DateTimeImmutable $obtenuAt): self
    {
        $this->obtenuAt = $obtenuAt;

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
}
