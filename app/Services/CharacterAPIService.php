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

    private function fetchCharacters(int $page = 1): array
    {
        $response = Http::get("{$this->url}/character?page={$page}");
        return $response->json();
    }

    private function getInfo(): array
    {
        $data = $this->fetchCharacters();
        return $data['info'];
    }

    public function getPagesCount(): int
    {
        $data = $this->getInfo();
        return $data['pages'];
    }

    public function getCharacters(int $page = 1): array
    {
        $data = $this->fetchCharacters($page);
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
