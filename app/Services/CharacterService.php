<?php

namespace App\Services;

use App\DTO\CharacterDTO;
use App\Exceptions\DuplicateCharacterException;
use App\Exceptions\InvalidPageParamException;
use App\Models\Character;
use App\Repositories\CharacterRepository;
use Illuminate\Database\UniqueConstraintViolationException;

class CharacterService
{
    public function __construct(
        private readonly CharacterAPIService $characterAPIService,
        private readonly CharacterRepository $characterRepository,
    ) {}

    /**
     * @throws InvalidPageParamException
     */
    public function verifyPageParam(int $page): void {
        $pagesCount = $this->characterAPIService->getPagesCount();

        if ($page < 1 or $page > $pagesCount) {
            throw new InvalidPageParamException($pagesCount);
        }
    }

    /**
     * @throws DuplicateCharacterException
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
     * @throws DuplicateCharacterException
     */
    private function loadCharacter(array $character): Character
    {
        try {
            $character['last_episode'] = $this->characterAPIService->getLastEpisodeOfCharacter($character);
            $characterDTO = CharacterDTO::fromAPI($character);

            return $this->characterRepository->create($characterDTO->toArray());
        } catch (UniqueConstraintViolationException) {
            throw new DuplicateCharacterException();
        }
    }
}
