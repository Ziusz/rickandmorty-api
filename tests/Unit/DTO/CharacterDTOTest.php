<?php

namespace Tests\Unit\DTO;

use App\DTO\CharacterDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CharacterDTOTest extends TestCase
{
    use RefreshDatabase;

    private array $validApiData;
    private CharacterDTO $characterDTO;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validApiData = [
            'name' => 'Rick Sanchez',
            'status' => 'Alive',
            'species' => 'Human',
            'origin' => ['name' => 'Earth (C-137)'],
            'location' => ['name' => 'Citadel of Ricks'],
            'last_episode' => 'Rickmurai Jack'
        ];

        $this->characterDTO = new CharacterDTO(
            name: 'Rick Sanchez',
            status: 'Alive',
            species: 'Human',
            origin: 'Earth (C-137)',
            location: 'Citadel of Ricks',
            lastEpisode: 'Rickmurai Jack'
        );
    }

    public function testCreateDTOFromConstructor(): void
    {
        $this->assertEquals('Rick Sanchez', $this->characterDTO->name);
        $this->assertEquals('Alive', $this->characterDTO->status);
        $this->assertEquals('Human', $this->characterDTO->species);
        $this->assertEquals('Earth (C-137)', $this->characterDTO->origin);
        $this->assertEquals('Citadel of Ricks', $this->characterDTO->location);
        $this->assertEquals('Rickmurai Jack', $this->characterDTO->lastEpisode);
    }

    public function testCreateDTOFromAPI(): void
    {
        $dto = CharacterDTO::fromAPI($this->validApiData);

        $this->assertEquals($this->validApiData['name'], $dto->name);
        $this->assertEquals($this->validApiData['status'], $dto->status);
        $this->assertEquals($this->validApiData['species'], $dto->species);
        $this->assertEquals($this->validApiData['origin']['name'], $dto->origin);
        $this->assertEquals($this->validApiData['location']['name'], $dto->location);
        $this->assertEquals($this->validApiData['last_episode'], $dto->lastEpisode);
    }

    public function testConvertDTOToArray(): void
    {
        $array = $this->characterDTO->toArray();

        $expectedArray = [
            'name' => 'Rick Sanchez',
            'status' => 'Alive',
            'species' => 'Human',
            'origin' => 'Earth (C-137)',
            'location' => 'Citadel of Ricks',
            'last_episode' => 'Rickmurai Jack'
        ];

        $this->assertEquals($expectedArray, $array);
    }
} 