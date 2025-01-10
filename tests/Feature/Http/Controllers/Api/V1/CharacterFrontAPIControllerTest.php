<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Models\Character;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CharacterFrontAPIControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsCharacterCollection(): void
    {
        $characters = Character::factory()->count(5)->create();
        $firstCharacter = $characters->first();

        $response = $this->getJson('/api/v1/characters');

        $response
            ->assertOk()
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'status',
                        'location',
                        'last_episode',
                        'species',
                        'origin',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ])
            ->assertJsonFragment([
                'id' => $firstCharacter->id,
                'name' => $firstCharacter->name,
                'status' => $firstCharacter->status,
                'location' => $firstCharacter->location,
                'last_episode' => $firstCharacter->last_episode,
                'species' => $firstCharacter->species,
                'origin' => $firstCharacter->origin
            ]);
    }

    public function testIndexReturnsEmptyCollection(): void
    {
        $response = $this->getJson('/api/v1/characters');

        $response
            ->assertOk()
            ->assertJsonCount(0, 'data')
            ->assertJsonStructure(['data']);
    }
}
