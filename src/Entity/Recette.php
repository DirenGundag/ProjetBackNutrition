<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $tempspreparation = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $tempsrepos = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $tempscuisson = null;

    #[ORM\Column(length: 255)]
    private ?string $ingredients = null;

    #[ORM\Column(length: 255)]
    private ?string $etapes = null;

    // #[ORM\Column(length: 255)]
    // private ?string $typesregimes = null;

    // #[ORM\Column(length: 255)]
    // private ?string $allergenes = null;

    #[ORM\ManyToMany(targetEntity: Allergie::class, mappedBy: 'recette')]
    private Collection $allergies;

    #[ORM\ManyToMany(targetEntity: Regime::class, mappedBy: 'recette')]
    private Collection $regimes;

    public function __construct()
    {
        $this->allergies = new ArrayCollection();
        $this->regimes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTempspreparation(): ?\DateTimeInterface
    {
        return $this->tempspreparation;
    }

    public function setTempspreparation(\DateTimeInterface $tempspreparation): self
    {
        $this->tempspreparation = $tempspreparation;

        return $this;
    }

    public function getTempsrepos(): ?\DateTimeInterface
    {
        return $this->tempsrepos;
    }

    public function setTempsrepos(\DateTimeInterface $tempsrepos): self
    {
        $this->tempsrepos = $tempsrepos;

        return $this;
    }

    public function getTempscuisson(): ?\DateTimeInterface
    {
        return $this->tempscuisson;
    }

    public function setTempscuisson(\DateTimeInterface $tempscuisson): self
    {
        $this->tempscuisson = $tempscuisson;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(string $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getEtapes(): ?string
    {
        return $this->etapes;
    }

    public function setEtapes(string $etapes): self
    {
        $this->etapes = $etapes;

        return $this;
    }


    // public function getTypesregimes(): ?string
    // {
    //     return $this->typesregimes;
    // }

    // public function setTypesregimes(string $typesregimes): self
    // {
    //     $this->typesregimes = $typesregimes;

    //     return $this;
    // }

    // public function getAllergenes(): ?string
    // {
    //     return $this->allergenes;
    // }

    // public function setAllergenes(string $allergenes): self
    // {
    //     $this->allergenes = $allergenes;

    //     return $this;
    // }

    /**
     * @return Collection<int, Allergie>
     */
    public function getAllergies(): Collection
    {
        return $this->allergies;
    }

    public function addAllergy(Allergie $allergy): self
    {
        if (!$this->allergies->contains($allergy)) {
            $this->allergies->add($allergy);
            $allergy->addRecette($this);
        }

        return $this;
    }

    public function removeAllergy(Allergie $allergy): self
    {
        if ($this->allergies->removeElement($allergy)) {
            $allergy->removeRecette($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Regime>
     */
    public function getRegimes(): Collection
    {
        return $this->regimes;
    }

    public function addRegime(Regime $regime): self
    {
        if (!$this->regimes->contains($regime)) {
            $this->regimes->add($regime);
            $regime->addRecette($this);
        }

        return $this;
    }

    public function removeRegime(Regime $regime): self
    {
        if ($this->regimes->removeElement($regime)) {
            $regime->removeRecette($this);
        }

        return $this;
    }
}
