<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $unUtilisateur;

    /**
     * @ORM\OneToMany(targetEntity=LigneCommandeFleur::class, mappedBy="uneCommande", cascade={"persist"})
     */
    private $ligneCommandeFleurs;

    public function __construct()
    {
        $this->ligneCommandeFleurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUnUtilisateur(): ?Utilisateur
    {
        return $this->unUtilisateur;
    }

    public function setUnUtilisateur(?Utilisateur $unUtilisateur): self
    {
        $this->unUtilisateur = $unUtilisateur;

        return $this;
    }

    /**
     * @return Collection|LigneCommandeFleur[]
     */
    public function getLigneCommandeFleurs(): Collection
    {
        return $this->ligneCommandeFleurs;
    }

    public function addLigneCommandeFleur(LigneCommandeFleur $ligneCommandeFleur): self
    {
        if (!$this->ligneCommandeFleurs->contains($ligneCommandeFleur)) {
            $this->ligneCommandeFleurs[] = $ligneCommandeFleur;
            $ligneCommandeFleur->setUneCommande($this);
        }

        return $this;
    }

    public function removeLigneCommandeFleur(LigneCommandeFleur $ligneCommandeFleur): self
    {
        if ($this->ligneCommandeFleurs->removeElement($ligneCommandeFleur)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommandeFleur->getUneCommande() === $this) {
                $ligneCommandeFleur->setUneCommande(null);
            }
        }

        return $this;
    }
}
