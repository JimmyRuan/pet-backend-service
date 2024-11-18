<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Pet;
use Doctrine\ORM\EntityManagerInterface;

class PetControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);

        // Clear the database for a clean test environment
        $this->entityManager->createQuery('DELETE FROM App\Entity\Pet')->execute();
    }

    public function testIndex(): void
    {
        // Create some pets
        $pet1 = new Pet();
        $pet1->setName('Buddy')->setType('Dog')->setBreed('Golden Retriever')
            ->setDateOfBirth(new \DateTime('2020-05-20'))->setGender('Male')->setIsDangerousAnimal(false);

        $pet2 = new Pet();
        $pet2->setName('Mittens')->setType('Cat')->setBreed('Siamese')
            ->setDateOfBirth(new \DateTime('2019-03-10'))->setGender('Female')->setIsDangerousAnimal(false);

        $this->entityManager->persist($pet1);
        $this->entityManager->persist($pet2);
        $this->entityManager->flush();

        // Test the index endpoint
        $this->client->request('GET', '/api/pets');
        $response = $this->client->getResponse();

        $this->assertResponseIsSuccessful();
        $data = json_decode($response->getContent(), true);

        $this->assertCount(2, $data);
        $this->assertEquals('Buddy', $data[0]['name']);
        $this->assertEquals('Mittens', $data[1]['name']);
    }

    public function testShow(): void
    {
        // Create a pet
        $pet = new Pet();
        $pet->setName('Buddy')->setType('Dog')->setBreed('Golden Retriever')
            ->setDateOfBirth(new \DateTime('2020-05-20'))->setGender('Male')->setIsDangerousAnimal(false);

        $this->entityManager->persist($pet);
        $this->entityManager->flush();

        // Test the show endpoint
        $this->client->request('GET', '/api/pets/' . $pet->getId());
        $response = $this->client->getResponse();

        $this->assertResponseIsSuccessful();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals('Buddy', $data['name']);
        $this->assertEquals('Dog', $data['type']);
    }

    public function testShowNotFound(): void
    {
        // Test the show endpoint with a non-existing pet
        $this->client->request('GET', '/api/pets/999');
        $response = $this->client->getResponse();

        $this->assertResponseStatusCodeSame(404);
        $data = json_decode($response->getContent(), true);

        $this->assertEquals('Pet not found', $data['message']);
    }

    public function testStore(): void
    {
        // Test the store endpoint
        $payload = [
            'name' => 'Buddy',
            'type' => 'Dog',
            'breed' => 'Golden Retriever',
            'date_of_birth' => '2020-05-20',
            'gender' => 'Male',
            'is_dangerous_animal' => false,
        ];

        $this->client->request('POST', '/api/pets', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($payload));
        $response = $this->client->getResponse();

        $this->assertResponseStatusCodeSame(201);
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('Pet created successfully', $data['message']);
        $this->assertEquals('Buddy', $data['pet']['name']);
    }
}
