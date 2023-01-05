<?php

namespace App\Entity;

use App\Repository\DocteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocteurRepository::class)
 */
class Docteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=Horaire::class, mappedBy="medecin")
     */
    private $horaires;

    /**
     * @ORM\ManyToMany(targetEntity=TypeConsultation::class, mappedBy="medecin")
     */
    private $typeConsultations;

    /**
     * @ORM\OneToMany(targetEntity=RDV::class, mappedBy="medecin")
     */
    private $rDVs;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="docteur", cascade={"persist", "remove"})
     */
    private $user;


    public function __construct()
    {
        $this->horaires = new ArrayCollection();
        $this->typeConsultations = new ArrayCollection();
        $this->rDVs = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection<int, RDV>
     */
    public function getRDVs(): Collection
    {
        return $this->rDVs;
    }

    public function addRDV(RDV $rDV): self
    {
        if (!$this->rDVs->contains($rDV)) {
            $this->rDVs[] = $rDV;
            $rDV->setMedecin($this);
        }

        return $this;
    }

    public function removeRDV(RDV $rDV): self
    {
        if ($this->rDVs->removeElement($rDV)) {
            // set the owning side to null (unless already changed)
            if ($rDV->getMedecin() === $this) {
                $rDV->setMedecin(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
