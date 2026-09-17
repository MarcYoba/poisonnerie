<?php

namespace App\Entity;

use App\Repository\LigneVenteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneVenteRepository::class)]
class LigneVente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ligneVentes')]
    private ?Vente $vente = null;

    #[ORM\ManyToOne(inversedBy: 'ligneVentes')]
    private ?Produit $produit = null;

    #[ORM\Column]
    private ?float $quantitePoids = null;

    #[ORM\Column]
    private ?float $prixUnitaire = null;

    #[ORM\Column(nullable: true)]
    private ?float $sousTotalHt = null;

    #[ORM\Column(nullable: true)]
    private ?float $sousTotalTtc = null;

    #[ORM\ManyToOne(inversedBy: 'ligneVentes')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVente(): ?Vente
    {
        return $this->vente;
    }

    public function setVente(?Vente $vente): static
    {
        $this->vente = $vente;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantitePoids(): ?float
    {
        return $this->quantitePoids;
    }

    public function setQuantitePoids(float $quantitePoids): static
    {
        $this->quantitePoids = $quantitePoids;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getSousTotalHt(): ?float
    {
        return $this->sousTotalHt;
    }

    public function setSousTotalHt(float $sousTotalHt): static
    {
        $this->sousTotalHt = $sousTotalHt;

        return $this;
    }

    public function getSousTotalTtc(): ?float
    {
        return $this->sousTotalTtc;
    }

    public function setSousTotalTtc(float $sousTotalTtc): static
    {
        $this->sousTotalTtc = $sousTotalTtc;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Calcule automatiquement les sous-totaux en fonction de la quantité/poids et du prix unitaire.
     */
    private function recalculerSousTotaux(): void
    {
        if ($this->quantitePoids !== null && $this->prixUnitaire !== null) {
            $poids = (float) $this->quantitePoids;
            $prix = (float) $this->prixUnitaire;

            $total = round($poids * $prix, 2);
            $this->sousTotalTtc = (string) $total;
            $this->sousTotalHt = (string) $total; // Ajuster avec le taux de TVA si nécessaire
        }
    }
}
