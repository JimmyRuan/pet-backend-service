<?php

namespace App\Tests\Controller;

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

        // Clear the database
        $this->entityManager->createQuery('DELETE FROM App\Entity\Pet')->execute();
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

        $this->client->request('POST', '/pets', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($payload));
        $response = $this->client->getResponse();

        $this->assertResponseStatusCodeSame(201);
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('Pet created successfully', $data['message']);
        $this->assertEquals('Buddy', $data['pet']['name']);
    }
}
