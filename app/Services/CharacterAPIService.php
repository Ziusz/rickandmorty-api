<?php

namespace App\Services;

use App\Contracts\CharacterAPIServiceInterface;
use App\Exceptions\RickAndMortyAPIException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class CharacterAPIService implements CharacterAPIServiceInterface
{
    private string $url;
    private int $timeout;

    public function __construct()
    {
        $this->url = config('services.rick_and_morty_api.url');
        $this->timeout = config('services.rick_and_morty_api.timeout');
    }

    /**
     * @return array<string, mixed>
     * @throws RickAndMortyAPIException
     */
    private function fetchCharacters(int $page = 1): array
    {
        try {
            $response = Http::timeout($this->timeout)->get("{$this->url}/character?page={$page}");

            if (!$response->successful()) {
                throw new RickAndMortyAPIException();
            }

            return $response->json();
        } catch (ConnectionException $e) {
            throw new RickAndMortyAPIException();
        }
    }

    /**
     * @return array<string, mixed>
     * @throws RickAndMortyAPIException
     */
    private function getInfo(): array
    {
        $data = $this->fetchCharacters();
        return $data['info'];
    }

    /**
     * @return int
     * @throws RickAndMortyAPIException
     */
    public function getPagesCount(): int
    {
        $data = $this->getInfo();
        return $data['pages'];
    }

    /**
     * @return array<string, mixed>
     * @throws RickAndMortyAPIException
     */
    public function getCharacters(int $page = 1): array
    {
        $data = $this->fetchCharacters($page);
        return $data['results'];
    }

    /**
     * @param string $episodeUrl
     * @return array<string, mixed>
     * @throws RickAndMortyAPIException
     */
    private function fetchEpisode(string $episodeUrl): array {
        try {
            $response = Http::timeout($this->timeout)->get($episodeUrl);

            if (!$response->successful()) {
                throw new RickAndMortyAPIException();
            }

            return $response->json();
        } catch (ConnectionException $e) {
            throw new RickAndMortyAPIException();
        }
    }

    /**
     * @param string $episodeUrl
     * @return string
     * @throws RickAndMortyAPIException
     */
    private function getEpisodeName(string $episodeUrl): string {
        $episode = $this->fetchEpisode($episodeUrl);
        return $episode['name'];
    }

    /**
     * @param array<string, mixed> $character
     * @return string
     */
    public function getLastEpisodeOfCharacter(array $character): string {
        $lastEpisodeUrl = last($character['episode']);
        return $this->getEpisodeName($lastEpisodeUrl);
    }
}
