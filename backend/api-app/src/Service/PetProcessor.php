<?php

namespace App\Service;

use App\Entity\Pet;
use Doctrine\ORM\EntityManagerInterface;

class PetProcessor
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Creates and stores a new Pet entity from given data.
     */
    public function storePet(array $data): Pet
    {
        $pet = new Pet();
        $pet->setName($data['name'])
            ->setType($data['type'])
            ->setBreed($data['breed'])
            ->setDateOfBirth(new \DateTime($data['date_of_birth']))
            ->setGender($data['gender']);

        // Determine if the breed is dangerous
        $isDangerous = $this->isBreedDangerous($data['breed']);
        $pet->setIsDangerousAnimal($isDangerous);

        $this->entityManager->persist($pet);
        $this->entityManager->flush();

        return $pet;
    }

    /**
     * Fetches all pets from the database.
     */
    public function getAllPets(): array
    {
        return $this->entityManager->getRepository(Pet::class)->findAll();
    }

    /**
     * Fetches a single pet by ID.
     */
    public function getPetById(int $id): ?Pet
    {
        return $this->entityManager->getRepository(Pet::class)->find($id);
    }

    /**
     * Checks if a breed is considered dangerous.
     */
    private function isBreedDangerous(string $breed): bool
    {
        $dangerousBreeds = $this->dangerousBreeds();
        return in_array($breed, $dangerousBreeds, true);
    }

    /**
     * Returns a list of dangerous breeds.
     */
    private function dangerousBreeds(): array
    {
        return [
            'Pitbull',
            'Mastiff',
            'Rottweiler',
            'Doberman Pinscher',
            'Akita',
        ];
    }
}
