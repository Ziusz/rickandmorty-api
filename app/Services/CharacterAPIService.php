<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CharacterAPIService
{
    private string $url;

    public function __construct()
    {
        $this->url = config('services.rick_and_morty_api.url');
    }

    public function fetchCharacters(int $page): array
    {
        $response = Http::get("{$this->url}/character?page={$page}");
        $data = $response->json();

        return $data['results'];
    }

    private function fetchEpisode(string $episodeUrl): array {
        $response = Http::get($episodeUrl);
        return $response->json();
    }

    public function getEpisodeName(string $episodeUrl): string {
        $episode = $this->fetchEpisode($episodeUrl);
        return $episode['name'];
    }
}
