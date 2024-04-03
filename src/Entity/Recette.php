<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity('nom')]
#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\Length(min: 3, max: 150, minMessage: 'Le nom de la recette doit contenir entre 3 et 150 caractères', maxMessage: 'Le nom de la recette doit contenir entre 3 et 150 caractères')]
    #[Assert\NotBlank()]
    private ?string $nom = null;

    #[ORM\Column(nullable: true)]
    #[Assert\LessThanOrEqual(1440, message: 'La durée doit se situer entre 2 et 1440 minutes')]
    #[Assert\GreaterThanOrEqual(2, message: 'La durée doit se situer entre 2 et 1440 minutes')]
    #[Assert\Positive()]
    private ?int $duree = null;

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank()]
    private ?string $difficulte = null;

    #[ORM\Column(length: 400)]
    #[Assert\Length(min: 20, max: 400, minMessage: 'La description doit contenir entre 20 et 400 caractères', maxMessage: 'La description doit contenir entre 20 et 400 caractères')]
    #[Assert\NotBlank()]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Ingredient::class)]
    private Collection $ingredient;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->ingredient = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDifficulte(): ?string
    {
        return $this->difficulte;
    }

    public function setDifficulte(string $difficulte): static
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredient(): Collection
    {
        return $this->ingredient;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredient->contains($ingredient)) {
            $this->ingredient->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        $this->ingredient->removeElement($ingredient);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

   
}
