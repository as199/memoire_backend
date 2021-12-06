<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CertificationRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CertificationRepository::class)
 * @ApiResource(
 * attributes={
 *         "security"="is_granted('ROLE_CHEF_DEPARTEMENT') || is_granted('ROLE_CHEF_SERVICE') || is_granted('ROLE_AUDITEUR')"
 *     },
 *     normalizationContext={"groups"={"read"}}
 * )
 */
class Certification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"read"})
     */
    private $obtenuAt;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="certifications")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read"})
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
