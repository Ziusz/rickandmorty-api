<?php

namespace Tests\Unit\Services;

use App\Contracts\CharacterAPIServiceInterface;
use App\Contracts\CharacterRepositoryInterface;
use App\DTO\CharacterDTO;
use App\Exceptions\DuplicateCharacterException;
use App\Exceptions\InvalidPageParamException;
use App\Models\Character;
use App\Services\CharacterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class CharacterServiceTest extends TestCase
{
    use RefreshDatabase;

    private CharacterService $characterService;
    private CharacterAPIServiceInterface $characterAPIService;
    private CharacterRepositoryInterface $characterRepository;
    private array $mockCharacterData;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->characterAPIService = Mockery::mock(CharacterAPIServiceInterface::class);
        $this->characterRepository = Mockery::mock(CharacterRepositoryInterface::class);
        
        $this->characterService = new CharacterService(
            $this->characterAPIService,
            $this->characterRepository
        );

        $this->mockCharacterData = [
            'name' => 'Rick Sanchez',
            'status' => 'Alive',
            'species' => 'Human',
            'origin' => ['name' => 'Earth (C-137)'],
            'location' => ['name' => 'Citadel of Ricks'],
            'episode' => ['https://rickandmortyapi.com/api/episode/50', 'https://rickandmortyapi.com/api/episode/51'],
        ];
    }

    public function testVerifyPageParamWithValidNumber(): void
    {
        $this->characterAPIService
            ->shouldReceive('getPagesCount')
            ->once()
            ->andReturn(42);

        $this->characterService->verifyPageParam(2);
        $this->assertTrue(true);
    }

    public function testVerifyPageParamWithInvalidPageThrowsException(): void
    {
        $this->expectException(InvalidPageParamException::class);

        $this->characterAPIService
            ->shouldReceive('getPagesCount')
            ->once()
            ->andReturn(42);

        $this->characterService->verifyPageParam(43);
    }

    public function testLoadCharactersSuccessfully(): void
    {
        $this->characterAPIService
            ->shouldReceive('getCharacters')
            ->once()
            ->with(1)
            ->andReturn([$this->mockCharacterData]);

        $this->characterAPIService
            ->shouldReceive('getLastEpisodeOfCharacter')
            ->once()
            ->with($this->mockCharacterData)
            ->andReturn('episode2');

        $character = new Character();
        $character->name = 'Rick Sanchez';

        $this->characterRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn($character);

        $result = $this->characterService->loadCharacters(1);

        $this->assertCount(1, $result);
        $this->assertEquals('success', $result[0]['status']);
        $this->assertStringContainsString('Rick Sanchez', $result[0]['message']);
    }

    public function testLoadCharactersWithDuplicateCharacterThrowsException(): void
    {
        $this->characterAPIService
            ->shouldReceive('getCharacters')
            ->once()
            ->with(1)
            ->andReturn([$this->mockCharacterData]);

        $this->characterAPIService
            ->shouldReceive('getLastEpisodeOfCharacter')
            ->once()
            ->with($this->mockCharacterData)
            ->andReturn('Rickmurai Jack');

        $this->characterRepository
            ->shouldReceive('create')
            ->once()
            ->andThrow(DuplicateCharacterException::class);

        $result = $this->characterService->loadCharacters(1);

        $this->assertCount(1, $result);
        $this->assertEquals('error', $result[0]['status']);
        $this->assertStringContainsString('Rick Sanchez', $result[0]['message']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
} 