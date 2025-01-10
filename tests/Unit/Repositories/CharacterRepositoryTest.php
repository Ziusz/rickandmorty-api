<?php

namespace Tests\Unit\Repositories;

use App\Models\Character;
use App\Repositories\CharacterRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CharacterRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private CharacterRepository $repository;
    private array $characterData;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->repository = new CharacterRepository();
        $this->characterData = [
            'name' => 'Rick Sanchez',
            'status' => 'Alive',
            'species' => 'Human',
            'origin' => 'Earth (C-137)',
            'location' => 'Citadel of Ricks',
            'last_episode' => 'Rickmurai Jack'
        ];
    }

    public function testCreateCharacter(): void
    {
        $character = $this->repository->create($this->characterData);

        $this->assertInstanceOf(Character::class, $character);
        $this->assertDatabaseHas('characters', $this->characterData);
        $this->assertEquals($this->characterData['name'], $character->name);
        $this->assertEquals($this->characterData['status'], $character->status);
        $this->assertEquals($this->characterData['species'], $character->species);
        $this->assertEquals($this->characterData['origin'], $character->origin);
        $this->assertEquals($this->characterData['location'], $character->location);
        $this->assertEquals($this->characterData['last_episode'], $character->last_episode);
    }

    public function testGetAllCharacters(): void
    {
        Character::factory()->count(3)->create();
        $character = Character::factory()->create($this->characterData);

        $characters = $this->repository->getAll();

        $this->assertCount(4, $characters);
        $this->assertTrue($characters->contains($character));
    }
} 