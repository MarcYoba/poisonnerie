<?php

namespace App\Entity;

use App\Repository\SalaryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalaryRepository::class)]
class Salary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'salaries')]
    private ?Employee $employee = null;

    #[ORM\Column(length: 20)]
    private ?string $mois = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $annee = null;

    #[ORM\Column]
    private ?float $prime = null;

    #[ORM\Column]
    private ?float $reductions = null;

    #[ORM\Column]
    private ?float $netApayer = null;

    #[ORM\ManyToOne(inversedBy: 'salaries')]
    private ?User $user = null;

    #[ORM\Column]
    private ?float $montantDeBase = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $paidAt = null;

    #[ORM\Column(length: 50)]
    private ?string $statut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): static
    {
        $this->employee = $employee;

        return $this;
    }

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(string $mois): static
    {
        $this->mois = $mois;

        return $this;
    }

    public function getAnnee(): ?\DateTime
    {
        return $this->annee;
    }

    public function setAnnee(\DateTime $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getPrime(): ?float
    {
        return $this->prime;
    }

    public function setPrime(float $prime): static
    {
        $this->prime = $prime;

        return $this;
    }

    public function getReductions(): ?float
    {
        return $this->reductions;
    }

    public function setReductions(float $reductions): static
    {
        $this->reductions = $reductions;

        return $this;
    }

    /**
     * Calcul automatique du salaire net avant enregistrement et mise à jour
     */
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function calculateNet(): void
    {
        $base = $this->montantDeBase ?? 0;
        $primes = $this->prime ?? 0;
        $deductions = $this->reductions ?? 0;

        $this->netApayer = ($base + $primes) - $deductions;
    }
    
    public function getNetApayer(): ?float
    {
        return $this->netApayer;
    }

    public function setNetApayer(float $netApayer): static
    {
        $this->netApayer = $netApayer;

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

    public function getMontantDeBase(): ?float
    {
        return $this->montantDeBase;
    }

    public function setMontantDeBase(float $montantDeBase): static
    {
        $this->montantDeBase = $montantDeBase;

        return $this;
    }

    public function getPaidAt(): ?\DateTime
    {
        return $this->paidAt;
    }

    public function setPaidAt(\DateTime $paidAt): static
    {
        $this->paidAt = $paidAt;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}
