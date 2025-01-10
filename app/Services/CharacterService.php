<?php

namespace App\Services;

use App\Exceptions\DuplicateCharacterException;
use App\Exceptions\InvalidPageParamException;
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
    public function loadCharacters(int $page): void {
        try {
            $characters = $this->characterAPIService->getCharacters($page);

            foreach ($characters as $character) {
                $lastEpisodeUrl = last($character['episode']);
                $lastEpisodeName = $this->characterAPIService->getEpisodeName($lastEpisodeUrl);

                $this->characterRepository->create([
                    'name' => $character['name'],
                    'status' => $character['status'],
                    'location' => $character['location']['name'],
                    'last_episode' => $lastEpisodeName,
                    'species' => $character['species'],
                    'origin' => $character['origin']['name'],
                ]);

            }
        } catch (UniqueConstraintViolationException) {
            throw new DuplicateCharacterException();
        }
    }
}
