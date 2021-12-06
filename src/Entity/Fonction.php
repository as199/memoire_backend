<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FonctionRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FonctionRepository::class)
 * @ApiResource(
 *     attributes={
 *         "security"="is_granted('ROLE_ADMIN')"
 *     },
 *      normalizationContext = {"groups"={"read_fonc"}}
 * )
 */
class Fonction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read_fonc","read_user"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_fonc","read_user"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read_fonc"})
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, mappedBy="fonction")
     * @Groups({"read_fonc"})
     */
    private $utilisateurs;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
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
            $utilisateur->setFonction($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getFonction() === $this) {
                $utilisateur->setFonction(null);
            }
        }

        return $this;
    }
}
