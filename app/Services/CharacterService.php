<?php

namespace App\Services;

use App\Models\Character;

class CharacterService
{
    public function __construct(private readonly CharacterAPIService $characterAPIService){}

    public function loadCharacters(int $page): void {
        $characters = $this->characterAPIService->fetchCharacters($page);

        foreach ($characters as $character) {
            $lastEpisodeUrl = last($character['episode']);
            $lastEpisodeName = $this->characterAPIService->getEpisodeName($lastEpisodeUrl);

            Character::create([
                'name' => $character['name'],
                'status' => $character['status'],
                'location' => $character['location']['name'],
                'last_episode' => $lastEpisodeName,
                'species' => $character['species'],
                'origin' => $character['origin']['name'],
            ]);

        }
    }
}
