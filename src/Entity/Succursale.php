<?php

namespace App\Entity;

use App\Repository\SuccursaleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SuccursaleRepository::class)
 */
class Succursale
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
    private $libellelibelle;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbre_employer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $quartier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $arrondissement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\ManyToOne(targetEntity=Entite::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $entite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibellelibelle(): ?string
    {
        return $this->libellelibelle;
    }

    public function setLibellelibelle(string $libellelibelle): self
    {
        $this->libellelibelle = $libellelibelle;

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

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(string $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getArrondissement(): ?string
    {
        return $this->arrondissement;
    }

    public function setArrondissement(string $arrondissement): self
    {
        $this->arrondissement = $arrondissement;

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

    public function getEntite(): ?entite
    {
        return $this->entite;
    }

    public function setEntite(?entite $entite): self
    {
        $this->entite = $entite;

        return $this;
    }
}
