<?php

namespace App\Entity;

use App\Repository\AuditCompteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditCompteRepository::class)]
class AuditCompte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $type_action = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_mise_jour = null;

    #[ORM\Column]
    private ?int $solde_ancien = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeAction(): ?string
    {
        return $this->type_action;
    }

    public function setTypeAction(string $type_action): static
    {
        $this->type_action = $type_action;

        return $this;
    }

    public function getDateMiseJour(): ?\DateTimeInterface
    {
        return $this->date_mise_jour;
    }

    public function setDateMiseJour(\DateTimeInterface $date_mise_jour): static
    {
        $this->date_mise_jour = $date_mise_jour;

        return $this;
    }

    public function getSoldeAncien(): ?int
    {
        return $this->solde_ancien;
    }

    public function setSoldeAncien(int $solde_ancien): static
    {
        $this->solde_ancien = $solde_ancien;

        return $this;
    }
}
