<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PetRepository;

#[ORM\Entity(repositoryClass: PetRepository::class)]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $breed = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(type: 'string', length: 10)]
    private ?string $gender = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isDangerousAnimal = false;

    // Getters and Setters
    public function getId(): ?int
    {
        return $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getBreed(): ?string
    {
        return $this->breed;
    }

    public function setBreed(string $breed): self
    {
        $this->breed = $breed;
        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function isDangerousAnimal(): bool
    {
        return $this->isDangerousAnimal;
    }

    public function setIsDangerousAnimal(bool $isDangerousAnimal): self
    {
        $this->isDangerousAnimal = $isDangerousAnimal;
        return $this;
    }
}
