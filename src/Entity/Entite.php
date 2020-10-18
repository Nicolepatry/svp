<?php

namespace App\Entity;

use App\Repository\EntiteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntiteRepository::class)
 */
class Entite
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
     * @ORM\Column(type="string", length=255)
     */
    private $numero;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbre_succursale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat_entite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $raison_sociale;

    /**
     * @ORM\Column(type="integer")
     */
    private $siege;

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

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getNbreSuccursale(): ?int
    {
        return $this->nbre_succursale;
    }

    public function setNbreSuccursale(int $nbre_succursale): self
    {
        $this->nbre_succursale = $nbre_succursale;

        return $this;
    }

    public function getEtatEntite(): ?string
    {
        return $this->etat_entite;
    }

    public function setEtatEntite(string $etat_entite): self
    {
        $this->etat_entite = $etat_entite;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raison_sociale;
    }

    public function setRaisonSociale(string $raison_sociale): self
    {
        $this->raison_sociale = $raison_sociale;

        return $this;
    }

    public function getSiege(): ?int
    {
        return $this->siege;
    }

    public function setSiege(int $siege): self
    {
        $this->siege = $siege;

        return $this;
    }
}
