<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
#[Vich\Uploadable]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'recette_image', fileNameProperty: 'imageName')]
    private $imageFile = null;

    #[ORM\Column(type: 'string')]
    private ?string $imageName = null;

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

    #[ORM\Column]
    private ?bool $access = null;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: Avis::class)]
    private Collection $avis;

    public function __construct()
    {
        $this->allergies = new ArrayCollection();
        $this->regimes = new ArrayCollection();
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
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

    public function isAccess(): ?bool
    {
        return $this->access;
    }

    public function setAccess(bool $access): self
    {
        $this->access = $access;

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setRecette($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getRecette() === $this) {
                $avi->setRecette(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titre;
    }
}
