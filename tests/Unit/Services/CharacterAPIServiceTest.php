<?php

namespace Tests\Unit\Services;

use App\Exceptions\RickAndMortyAPIException;
use App\Services\CharacterAPIService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CharacterAPIServiceTest extends TestCase
{
    use RefreshDatabase;

    private CharacterAPIService $characterAPIService;
    private string $baseUrl = 'https://rickandmortyapi.com/api';
    private string $lastEpisodeUrl = 'https://rickandmortyapi.com/api/episode/51';
    private array $mockCharacterData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->characterAPIService = new CharacterAPIService();

        $this->mockCharacterData = [
            'info' => [
                'count' => 826,
                'pages' => 42,
                'next' => 'https://rickandmortyapi.com/api/character?page=2',
                'prev' => null
            ],
            'results' => [
                [
                    'name' => 'Rick Sanchez',
                    'status' => 'Alive',
                    'species' => 'Human',
                    'origin' => ['name' => 'Earth (C-137)'],
                    'location' => ['name' => 'Citadel of Ricks'],
                    'episode' => ['https://rickandmortyapi.com/api/episode/51']
                ]
            ]
        ];
    }

    public function testGetPagesCount(): void
    {
        Http::fake(["{$this->baseUrl}/character?page=1" => Http::response($this->mockCharacterData)]);

        $pagesCount = $this->characterAPIService->getPagesCount();

        $this->assertEquals(42, $pagesCount);
    }

    public function testGetCharacters(): void
    {
        Http::fake(["{$this->baseUrl}/character?page=1" => Http::response($this->mockCharacterData)]);

        $characters = $this->characterAPIService->getCharacters(1);

        $this->assertCount(1, $characters);
        $this->assertEquals('Rick Sanchez', $characters[0]['name']);
    }

    public function testGetLastEpisodeOfCharacter(): void
    {
        $episodeData = ['name' => 'Rickmurai Jack'];
        Http::fake([$this->lastEpisodeUrl => Http::response($episodeData)]);

        $character = [
            'episode' => [$this->lastEpisodeUrl]
        ];

        $lastEpisode = $this->characterAPIService->getLastEpisodeOfCharacter($character);

        $this->assertEquals('Rickmurai Jack', $lastEpisode);
    }

    public function testThrowsExceptionOnConnectionError(): void
    {
        Http::fake(["{$this->baseUrl}/character?page=1" => Http::response(null, 500)]);

        $this->expectException(RickAndMortyAPIException::class);
        $this->characterAPIService->getCharacters(1);
    }
} 