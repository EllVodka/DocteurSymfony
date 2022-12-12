<?php

namespace App\Entity;

use App\Repository\RDVRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RDVRepository::class)
 */
class RDV
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rDVs")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Docteur::class, inversedBy="rDVs")
     */
    private $medecin;

    /**
     * @ORM\ManyToOne(targetEntity=TypeConsultation::class, inversedBy="rDVs")
     */
    private $typeConsultation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creneau;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getMedecin(): ?Docteur
    {
        return $this->medecin;
    }

    public function setMedecin(?Docteur $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getTypeConsultation(): ?TypeConsultation
    {
        return $this->typeConsultation;
    }

    public function setTypeConsultation(?TypeConsultation $typeConsultation): self
    {
        $this->typeConsultation = $typeConsultation;

        return $this;
    }

    public function getCreneau(): ?\DateTimeInterface
    {
        return $this->creneau;
    }

    public function setCreneau(\DateTimeInterface $creneau): self
    {
        $this->creneau = $creneau;

        return $this;
    }
}
