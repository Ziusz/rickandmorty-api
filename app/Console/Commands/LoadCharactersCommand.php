<?php

namespace App\Console\Commands;

use App\Models\Character;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class LoadCharactersCommand extends Command
{
    protected $signature = 'characters:load {page}';

    protected $description = 'Load characters from API and save them in database';

    public function handle()
    {
        $page = $this->argument('page');

        $response = Http::get('https://rickandmortyapi.com/api/character?page='.$page);
        $data = $response->json();
        $characters = $data['results'];

        foreach ($characters as $character) {
            $last_episode_url = last($character['episode']);
            $response = Http::get($last_episode_url);
            $last_episode = $response->json();

            Character::create([
                'name' => $character['name'],
                'status' => $character['status'],
                'location' => $character['location']['name'],
                'last_episode' => $last_episode['name'],
                'species' => $character['species'],
                'origin' => $character['origin']['name'],
            ]);
        }

        $this->info('Characters have been successfully added to the database!');
    }
}
