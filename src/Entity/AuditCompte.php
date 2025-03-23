<?php

namespace App\Entity;

use App\Repository\AuditCompteRepository;
use App\Repository\UserRepository;
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

    #[ORM\Column]
    private ?string $numero_compte = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_client = null;

    #[ORM\Column]
    private ?int $solde_nouveau = null;

    #[ORM\Column(length: 255)]
    private ?string $utilisateur = null;


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

    public function getNumeroCompte(): ?string
    {
        return $this->numero_compte;
    }

    public function setNumeroCompte(string $numero_compte): static
    {
        $this->numero_compte = $numero_compte;

        return $this;
    }

    public function getNomClient(): ?string
    {
        return $this->nom_client;
    }

    public function setNomClient(string $nom_client): static
    {
        $this->nom_client = $nom_client;

        return $this;
    }

    public function getSoldeNouveau(): ?int
    {
        return $this->solde_nouveau;
    }

    public function setSoldeNouveau(int $solde_nouveau): static
    {
        $this->solde_nouveau = $solde_nouveau;

        return $this;
    }

    // public function getUserName(UserRepository $userRepository): ?string
    // {
    //     $user=$userRepository->find($this->utilisateur);

    //     return $user->getUsername();
        
    // }
    public function setUtilisateur(string $utilisateur): static
    {
        
        $this->utilisateur = $utilisateur;

        return $this;
    }
    public function getUtilisateur(): ?string{
        // $user=$userRepository->find($this->utilisateur);

        // return $user->getUsername();
        return $this->utilisateur;
    
    }

}
