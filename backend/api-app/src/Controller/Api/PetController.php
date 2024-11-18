<?php

namespace App\Controller\Api;

use App\Service\PetProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PetController extends AbstractController
{
    private PetProcessor $petProcessor;

    public function __construct(PetProcessor $petProcessor)
    {
        $this->petProcessor = $petProcessor;
    }

    #[Route('/api/pets', name: 'api_pets_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $pets = $this->petProcessor->getAllPets();

        return $this->json($pets);
    }

    #[Route('/api/pets/{id}', name: 'api_pets_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $pet = $this->petProcessor->getPetById($id);
        if (!$pet) {
            return $this->json(['message' => 'Pet not found'], 404);
        }

        return $this->json($pet);
    }

    #[Route('/api/pets', name: 'api_pets_store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $pet = $this->petProcessor->storePet($data);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }

        return $this->json(['message' => 'Pet created successfully', 'pet' => $pet], 201);
    }
}
