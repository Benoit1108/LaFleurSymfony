<?php

namespace App\Entity;

use App\Repository\LigneCommandeFleurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LigneCommandeFleurRepository::class)
 */
class LigneCommandeFleur
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
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="ligneCommandeFleurs", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $uneCommande;

    /**
     * @ORM\ManyToOne(targetEntity=Fleur::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $uneFleur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getUneCommande(): ?Commande
    {
        return $this->uneCommande;
    }

    public function setUneCommande(?Commande $uneCommande): self
    {
        $this->uneCommande = $uneCommande;

        return $this;
    }

    public function getUneFleur(): ?Fleur
    {
        return $this->uneFleur;
    }

    public function setUneFleur(?Fleur $uneFleur): self
    {
        $this->uneFleur = $uneFleur;

        return $this;
    }
}
