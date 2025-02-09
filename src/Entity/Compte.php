<?php

namespace App\Entity;

use App\Repository\CompteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompteRepository::class)]
class Compte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero_compte = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_client = null;

    #[ORM\Column]
    private ?int $solde = null;

    /**
     * @var Collection<int, AuditeCompte>
     */
    #[ORM\OneToMany(targetEntity: AuditeCompte::class, mappedBy: 'compte')]
    private Collection $auditeComptes;

    public function __construct()
    {
        $this->auditeComptes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCompte(): ?int
    {
        return $this->numero_compte;
    }

    public function setNumeroCompte(int $numero_compte): static
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

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): static
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * @return Collection<int, AuditeCompte>
     */
    public function getAuditeComptes(): Collection
    {
        return $this->auditeComptes;
    }

    public function addAuditeCompte(AuditeCompte $auditeCompte): static
    {
        if (!$this->auditeComptes->contains($auditeCompte)) {
            $this->auditeComptes->add($auditeCompte);
            $auditeCompte->setCompte($this);
        }

        return $this;
    }

    public function removeAuditeCompte(AuditeCompte $auditeCompte): static
    {
        if ($this->auditeComptes->removeElement($auditeCompte)) {
            // set the owning side to null (unless already changed)
            if ($auditeCompte->getCompte() === $this) {
                $auditeCompte->setCompte(null);
            }
        }

        return $this;
    }
}
