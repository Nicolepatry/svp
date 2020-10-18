<?php

namespace App\Entity;

use App\Repository\DepartementDesEntiteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepartementDesEntiteRepository::class)
 */
class DepartementDesEntite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $chefdep;

    /**
     * @ORM\ManyToOne(targetEntity=Succursale::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $succursale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbre_employer;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChefdep(): ?int
    {
        return $this->chefdep;
    }

    public function setChefdep(int $chefdep): self
    {
        $this->chefdep = $chefdep;

        return $this;
    }

    public function getSuccursale(): ?succursale
    {
        return $this->succursale;
    }

    public function setSuccursale(?succursale $succursale): self
    {
        $this->succursale = $succursale;

        return $this;
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

    public function getNbreEmployer(): ?int
    {
        return $this->nbre_employer;
    }

    public function setNbreEmployer(int $nbre_employer): self
    {
        $this->nbre_employer = $nbre_employer;

        return $this;
    }

}
