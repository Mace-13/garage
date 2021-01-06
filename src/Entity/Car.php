<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *  fields={"marque"},
 *  message="Une autre annonce possède déjà ce titre, merci de le modifier"
 * )
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2, max=50, minMessage="La marque doit faire plus de 2 caractères", maxMessage="La marque ne peut pas faire plus de 50 caractères")
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2, max=50, minMessage="Le modele doit faire plus de 2 caractères", maxMessage="Le modele ne peut pas faire plus de 50 caractères")
     */
    private $modele;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="float")
     */
    private $km;

    /**
     * @ORM\Column(type="float")
     *
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $owner;

    /**
     * @ORM\Column(type="integer")
     */
    private $cylindre;

    /**
     * @ORM\Column(type="integer")
     */
    private $puissance;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=50, minMessage="Le carburant doit faire plus de 5 caractères", maxMessage="Le carburant ne peut pas faire plus de 50 caractères")
     */
    private $carburant;

    /**
     * @ORM\Column(type="date")
     */
    private $miseCirculation;

    /**
     * @ORM\Column(type="string", length=255)
     * (min=5, max=50, minMessage="La transmission doit faire plus de 5 caractères", maxMessage="La transmission ne peut pas faire plus de 50 caractères")
     */
    private $transmission;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=20, minMessage="Votre description doit faire plus de 20 caractères")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=20, minMessage="carOption doit faire plus de 20 caractères")
     */
    private $carOption;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $coverImage;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="car", orphanRemoval=true)
     * @Assert\Valid()
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /** crée un slug automatiquement
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeSlug()
    {
        if(empty($this->slug))
        {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->marque.'-'. $this->modele.'-'.rand(1,100000));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getKm(): ?float
    {
        return $this->km;
    }

    public function setKm(float $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getOwner(): ?int
    {
        return $this->owner;
    }

    public function setOwner(int $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCylindre(): ?int
    {
        return $this->cylindre;
    }

    public function setCylindre(int $cylindre): self
    {
        $this->cylindre = $cylindre;

        return $this;
    }

    public function getPuissance(): ?int
    {
        return $this->puissance;
    }

    public function setPuissance(int $puissance): self
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getCarburant(): ?string
    {
        return $this->carburant;
    }

    public function setCarburant(string $carburant): self
    {
        $this->carburant = $carburant;

        return $this;
    }

    public function getMiseCirculation(): ?\DateTimeInterface
    {
        return $this->miseCirculation;
    }

    public function setMiseCirculation(\DateTimeInterface $miseCirculation): self
    {
        $this->miseCirculation = $miseCirculation;

        return $this;
    }

    public function getTransmission(): ?string
    {
        return $this->transmission;
    }

    public function setTransmission(string $transmission): self
    {
        $this->transmission = $transmission;

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

    public function getCarOption(): ?string
    {
        return $this->carOption;
    }

    public function setCarOption(string $carOption): self
    {
        $this->carOption = $carOption;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setCar($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getCar() === $this) {
                $image->setCar(null);
            }
        }

        return $this;
    }
}
