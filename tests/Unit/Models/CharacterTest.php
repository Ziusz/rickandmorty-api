<?php

namespace Tests\Unit\Models;

use App\Models\Character;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CharacterTest extends TestCase
{
    use RefreshDatabase;

    public function testCharacterFactory(): void
    {
        $character = Character::factory()->create();

        $this->assertInstanceOf(Character::class, $character);
        $this->assertNotNull($character->name);
        $this->assertNotNull($character->status);
        $this->assertNotNull($character->species);
        $this->assertNotNull($character->origin);
        $this->assertNotNull($character->location);
        $this->assertNotNull($character->last_episode);
    }

    public function testCharacterHasAllFillableAttributes(): void
    {
        $expectedFillable = [
            'name',
            'status',
            'location',
            'last_episode',
            'species',
            'origin'
        ];

        $character = new Character();
        $this->assertEquals($expectedFillable, $character->getFillable());
    }

    public function testCharacterCanBeCreatedByMethod(): void
    {
        $characterData = [
            'name' => 'Rick Sanchez',
            'status' => 'Alive',
            'species' => 'Human',
            'origin' => 'Earth (C-137)',
            'location' => 'Citadel of Ricks',
            'last_episode' => 'Rickmurai Jack'
        ];

        $character = Character::create($characterData);

        $this->assertDatabaseHas('characters', $characterData);
        $this->assertEquals($characterData['name'], $character->name);
        $this->assertEquals($characterData['status'], $character->status);
        $this->assertEquals($characterData['species'], $character->species);
        $this->assertEquals($characterData['origin'], $character->origin);
        $this->assertEquals($characterData['location'], $character->location);
        $this->assertEquals($characterData['last_episode'], $character->last_episode);
    }
} 