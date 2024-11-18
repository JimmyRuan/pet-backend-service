<?php

namespace App\Tests\Service;

use App\Entity\Pet;
use App\Service\PetProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class PetProcessorTest extends TestCase
{
    private $entityManager;
    private $repository;
    private $petProcessor;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->repository = $this->createMock(EntityRepository::class);
        $this->entityManager
            ->method('getRepository')
            ->with(Pet::class)
            ->willReturn($this->repository);

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

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Pet::class));

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $pet = $this->petProcessor->storePet($data);

        $this->assertInstanceOf(Pet::class, $pet);
        $this->assertEquals('Buddy', $pet->getName());
        $this->assertEquals('Dog', $pet->getType());
        $this->assertEquals('Golden Retriever', $pet->getBreed());
        $this->assertEquals(new \DateTime('2020-05-20'), $pet->getDateOfBirth());
        $this->assertEquals('Male', $pet->getGender());
        $this->assertFalse($pet->isDangerousAnimal());
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

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Pet::class));

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

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
        $pet1 = (new Pet())->setName('Buddy')->setType('Dog');
        $pet2 = (new Pet())->setName('Mittens')->setType('Cat');

        $this->repository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([$pet1, $pet2]);

        $pets = $this->petProcessor->getAllPets();

        $this->assertCount(2, $pets);
        $this->assertEquals('Buddy', $pets[0]->getName());
        $this->assertEquals('Dog', $pets[0]->getType());
        $this->assertEquals('Mittens', $pets[1]->getName());
        $this->assertEquals('Cat', $pets[1]->getType());
    }

    public function testGetPetById(): void
    {
        $pet = (new Pet())->setName('Buddy')->setType('Dog');

        $this->repository
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($pet);

        $result = $this->petProcessor->getPetById(1);

        $this->assertInstanceOf(Pet::class, $result);
        $this->assertEquals('Buddy', $result->getName());
        $this->assertEquals('Dog', $result->getType());
    }

    public function testGetPetByIdReturnsNull(): void
    {
        $this->repository
            ->expects($this->once())
            ->method('find')
            ->with(999)
            ->willReturn(null);

        $result = $this->petProcessor->getPetById(999);

        $this->assertNull($result);
    }
}
