<?php

namespace App\Controller\Api;

use App\Entity\Pet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PetController extends AbstractController
{
    #[Route('/api/pets', name: 'api_pets_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $pets = $entityManager->getRepository(Pet::class)->findAll();

        return $this->json($pets);
    }

    #[Route('/api/pets/{id}', name: 'api_pets_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $pet = $entityManager->getRepository(Pet::class)->find($id);
        if (!$pet) {
            return $this->json(['message' => 'Pet not found'], 404);
        }

        return $this->json($pet);
    }

    #[Route('/api/pets', name: 'api_pets_store', methods: ['POST'])]
    public function store(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $pet = new Pet();
        $pet->setName($data['name'])
            ->setType($data['type'])
            ->setBreed($data['breed'])
            ->setDateOfBirth(new \DateTime($data['date_of_birth']))
            ->setGender($data['gender'])
            ->setIsDangerousAnimal($data['is_dangerous_animal']);

        $entityManager->persist($pet);
        $entityManager->flush();

        return $this->json(['message' => 'Pet created successfully', 'pet' => $pet], 201);
    }
}
