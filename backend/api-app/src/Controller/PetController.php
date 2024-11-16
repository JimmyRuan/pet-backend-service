<?php

namespace App\Controller;

use App\Entity\Pet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PetController extends AbstractController
{
    #[Route('/pets', name: 'pets_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $pets = $entityManager->getRepository(Pet::class)->findAll();

        return $this->json($pets);
    }

    #[Route('/pets', name: 'pets_store', methods: ['POST'])]
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
