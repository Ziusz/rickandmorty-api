<?php

namespace App\Services;

use App\DTO\CharacterDTO;
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
                $character['last_episode'] = $this->characterAPIService->getEpisodeName($lastEpisodeUrl);

                $characterDTO = CharacterDTO::fromAPI($character);

                $this->characterRepository->create($characterDTO->toArray());
            }
        } catch (UniqueConstraintViolationException) {
            throw new DuplicateCharacterException();
        }
    }
}
