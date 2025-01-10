<?php

namespace Tests\Feature\Console\Commands;

use App\Contracts\CharacterServiceInterface;
use App\Exceptions\InvalidPageParamException;
use App\Exceptions\RickAndMortyAPIException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class LoadCharactersCommandTest extends TestCase
{
    use RefreshDatabase;

    private $characterService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->characterService = Mockery::mock(CharacterServiceInterface::class);
        $this->app->instance(CharacterServiceInterface::class, $this->characterService);
    }

    public function testLoadCharacters(): void
    {
        $successMessage = 'Character Rick Sanchez was successfully added to the database!';
        $errorMessage = 'Character Morty Smith was skipped: This character already exist in the database!';

        $this->characterService
            ->shouldReceive('verifyPageParam')
            ->once()
            ->with(1);

        $this->characterService
            ->shouldReceive('loadCharacters')
            ->once()
            ->with(1)
            ->andReturn([
                ['status' => 'success', 'message' => $successMessage],
                ['status' => 'error', 'message' => $errorMessage]
            ]);

        $this->artisan('characters:load', ['page' => 1])
            ->expectsOutput($successMessage)
            ->expectsOutput($errorMessage)
            ->assertExitCode(0);
    }

    public function testLoadCharactersWithInvalidPage(): void
    {
        $errorMessage = 'Page parameter must be a number greater than 0 and less than 42!';

        $this->characterService
            ->shouldReceive('verifyPageParam')
            ->once()
            ->with(0)
            ->andThrow(new InvalidPageParamException(42));

        $this->artisan('characters:load', ['page' => 0])
            ->expectsOutput($errorMessage)
            ->assertExitCode(1);
    }

    public function testLoadCharactersWithAPIError(): void
    {
        $errorMessage = 'Rick and Morty API is not responding. Please try again later!';

        $this->characterService
            ->shouldReceive('verifyPageParam')
            ->once()
            ->with(1)
            ->andThrow(new RickAndMortyAPIException());

        $this->artisan('characters:load', ['page' => 1])
            ->expectsOutput($errorMessage)
            ->assertExitCode(1);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
} 