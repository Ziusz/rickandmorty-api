<?php

namespace App\Services;

use App\Contracts\CharacterAPIServiceInterface;
use App\Contracts\CharacterRepositoryInterface;
use App\Contracts\CharacterServiceInterface;
use App\DTO\CharacterDTO;
use App\Events\CharacterCreated;
use App\Exceptions\DuplicateCharacterException;
use App\Exceptions\InvalidPageParamException;
use App\Models\Character;
use Illuminate\Database\UniqueConstraintViolationException;

readonly class CharacterService implements CharacterServiceInterface
{
    public function __construct(
        private CharacterAPIServiceInterface $characterAPIService,
        private CharacterRepositoryInterface $characterRepository,
    ) {}

    /**
     * @param int $page
     * @throws InvalidPageParamException
     */
    public function verifyPageParam(int $page): void {
        $pagesCount = $this->characterAPIService->getPagesCount();

        if ($page < 1 or $page > $pagesCount) {
            throw new InvalidPageParamException($pagesCount);
        }
    }

    /**
     * @param int $page
     * @return array<string, mixed>
     */
    public function loadCharacters(int $page): array {
        $characters = $this->characterAPIService->getCharacters($page);
        $messages = [];

        foreach ($characters as $character) {
            try {
                $character = $this->loadCharacter($character);
                $messages[] = ['status' => 'success', 'message' => "Character {$character['name']} was successfully added to the database!"];
            } catch (DuplicateCharacterException $e) {
                $messages[] = ['status' => 'error', 'message' => "Character {$character['name']} was skipped: {$e->getMessage()}"];
            }
        }

        return $messages;
    }

    /**
     * @param array<string, mixed> $character
     * @return Character
     * @throws DuplicateCharacterException
     */
    private function loadCharacter(array $character): Character
    {
        try {
            $character['last_episode'] = $this->characterAPIService->getLastEpisodeOfCharacter($character);
            $characterDTO = CharacterDTO::fromAPI($character);

            $createdCharacter = $this->characterRepository->create($characterDTO->toArray());
            event(new CharacterCreated($createdCharacter));

            return $createdCharacter;
        } catch (UniqueConstraintViolationException) {
            throw new DuplicateCharacterException();
        }
    }
}
