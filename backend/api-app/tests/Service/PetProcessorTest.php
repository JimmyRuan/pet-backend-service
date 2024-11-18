<?php

namespace App\Tests\Service;

use App\Entity\Pet;
use App\Service\PetProcessor;
use App\Tests\Traits\TruncateDatabaseTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PetProcessorTest extends KernelTestCase
{
    use TruncateDatabaseTrait;

    private EntityManagerInterface $entityManager;
    private PetProcessor $petProcessor;

    protected function setUp(): void
    {
        self::bootKernel();

        // Retrieve the EntityManager from the service container
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);

        // Ensure the database is clean before running tests
        $this->truncateEntities($this->entityManager);

        $this->petProcessor = new PetProcessor($this->entityManager);
    }

    public function testStorePet(): void
    {
        $data = [
            'name' => 'Buddy',
            'type' => 'Dog',
            'breed' => 'Golden Retriever',
            'date_of_birth' => '2020-05-20',
            'gender' => 'Male',
        ];

        $pet = $this->petProcessor->storePet($data);

        $this->assertInstanceOf(Pet::class, $pet);
        $this->assertEquals('Buddy', $pet->getName());
        $this->assertEquals('Dog', $pet->getType());
        $this->assertEquals('Golden Retriever', $pet->getBreed());
        $this->assertEquals(new \DateTime('2020-05-20'), $pet->getDateOfBirth());
        $this->assertEquals('Male', $pet->getGender());
        $this->assertFalse($pet->isDangerousAnimal());

        // Verify the pet is stored in the database
        $storedPet = $this->entityManager->getRepository(Pet::class)->find($pet->getId());
        $this->assertNotNull($storedPet);
        $this->assertEquals('Buddy', $storedPet->getName());
    }

    public function testStorePetWithDangerousBreed(): void
    {
        $data = [
            'name' => 'Max',
            'type' => 'Dog',
            'breed' => 'Pitbull',
            'date_of_birth' => '2018-03-15',
            'gender' => 'Male',
        ];

        $pet = $this->petProcessor->storePet($data);

        $this->assertInstanceOf(Pet::class, $pet);
        $this->assertEquals('Max', $pet->getName());
        $this->assertEquals('Dog', $pet->getType());
        $this->assertEquals('Pitbull', $pet->getBreed());
        $this->assertEquals(new \DateTime('2018-03-15'), $pet->getDateOfBirth());
        $this->assertEquals('Male', $pet->getGender());
        $this->assertTrue($pet->isDangerousAnimal());
    }

    public function testGetAllPets(): void
    {
        $pet1 = (new Pet())
            ->setName('Buddy')
            ->setType('Dog')
            ->setBreed('Golden Retriever')
            ->setDateOfBirth(new \DateTime('2020-05-20'))
            ->setGender('Male')
            ->setIsDangerousAnimal(false);

        $pet2 = (new Pet())
            ->setName('Mittens')
            ->setType('Cat')
            ->setBreed('Siamese')
            ->setDateOfBirth(new \DateTime('2019-01-15'))
            ->setGender('Female')
            ->setIsDangerousAnimal(false);

        $this->entityManager->persist($pet1);
        $this->entityManager->persist($pet2);
        $this->entityManager->flush();

        $pets = $this->petProcessor->getAllPets();

        $this->assertCount(2, $pets);
        $this->assertEquals('Buddy', $pets[0]->getName());
        $this->assertEquals('Mittens', $pets[1]->getName());
    }

    public function testGetPetById(): void
    {
        $pet = (new Pet())
            ->setName('Buddy')
            ->setType('Dog')
            ->setBreed('Golden Retriever')
            ->setDateOfBirth(new \DateTime('2020-05-20'))
            ->setGender('Male')
            ->setIsDangerousAnimal(false);

        $this->entityManager->persist($pet);
        $this->entityManager->flush();

        $result = $this->petProcessor->getPetById($pet->getId());

        $this->assertInstanceOf(Pet::class, $result);
        $this->assertEquals('Buddy', $result->getName());
        $this->assertEquals('Dog', $result->getType());
    }

    public function testGetPetByIdReturnsNull(): void
    {
        $result = $this->petProcessor->getPetById(999);

        $this->assertNull($result);
    }
}
