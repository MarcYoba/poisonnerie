<?php

namespace App\Entity;

use App\Repository\VenteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VenteRepository::class)]
class Vente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroFacture = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $createtAt = null;

    #[ORM\Column]
    private ?float $montantTotalHt = null;

    #[ORM\Column]
    private ?float $montantTva = null;

    #[ORM\Column]
    private ?float $montantTotalTtc = null;

    #[ORM\Column]
    private ?float $remise = null;

    #[ORM\Column(length: 50)]
    private ?string $statuspaiement = null;

    #[ORM\ManyToOne(inversedBy: 'ventes')]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'ventes')]
    private ?User $user = null;

    /**
     * @var Collection<int, LigneVente>
     */
    #[ORM\OneToMany(targetEntity: LigneVente::class, mappedBy: 'vente', 
        cascade: ['persist', 'remove'], // <--- IMPORTANT : cascade persist
        orphanRemoval: true)]
    private Collection $ligneVentes;

    public function __construct()
    {
        $this->ligneVentes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroFacture(): ?string
    {
        return $this->numeroFacture;
    }

    public function setNumeroFacture(string $numeroFacture): static
    {
        $this->numeroFacture = $numeroFacture;

        return $this;
    }

    public function getCreatetAt(): ?\DateTime
    {
        return $this->createtAt;
    }

    public function setCreatetAt(\DateTime $createtAt): static
    {
        $this->createtAt = $createtAt;

        return $this;
    }

    public function getMontantTotalHt(): ?float
    {
        return $this->montantTotalHt;
    }

    public function setMontantTotalHt(float $montantTotalHt): static
    {
        $this->montantTotalHt = $montantTotalHt;

        return $this;
    }

    public function getMontantTva(): ?float
    {
        return $this->montantTva;
    }

    public function setMontantTva(float $montantTva): static
    {
        $this->montantTva = $montantTva;

        return $this;
    }

    public function getMontantTotalTtc(): ?float
    {
        return $this->montantTotalTtc;
    }

    public function setMontantTotalTtc(float $montantTotalTtc): static
    {
        $this->montantTotalTtc = $montantTotalTtc;

        return $this;
    }

    public function getRemise(): ?float
    {
        return $this->remise;
    }

    public function setRemise(float $remise): static
    {
        $this->remise = $remise;

        return $this;
    }

    public function getStatuspaiement(): ?string
    {
        return $this->statuspaiement;
    }

    public function setStatuspaiement(string $statuspaiement): static
    {
        $this->statuspaiement = $statuspaiement;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

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
     * @return Collection<int, LigneVente>
     */
    public function getLigneVentes(): Collection
    {
        return $this->ligneVentes;
    }

    public function addLigneVente(LigneVente $ligneVente): static
    {
        if (!$this->ligneVentes->contains($ligneVente)) {
            $this->ligneVentes->add($ligneVente);
            $ligneVente->setVente($this);
        }

        return $this;
    }

    public function removeLigneVente(LigneVente $ligneVente): static
    {
        if ($this->ligneVentes->removeElement($ligneVente)) {
            // set the owning side to null (unless already changed)
            if ($ligneVente->getVente() === $this) {
                $ligneVente->setVente(null);
            }
        }

        return $this;
    }
}
