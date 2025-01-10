<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Services\CharacterAPIService;
use Illuminate\Console\Command;

class LoadCharactersCommand extends Command
{
    protected $signature = 'characters:load {page}';
    protected $description = 'Load characters from API and save them in the database';
    protected CharacterAPIService $characterAPIService;

    public function __construct(CharacterAPIService $characterAPIService)
    {
        parent::__construct();
        $this->characterAPIService = $characterAPIService;
    }

    public function handle()
    {
        $page = (int) $this->argument('page');
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

        $this->info('Characters have been successfully added to the database!');
    }
}
