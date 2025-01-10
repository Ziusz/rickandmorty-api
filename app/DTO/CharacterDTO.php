<?php

namespace App\DTO;

readonly class CharacterDTO
{
    public function __construct(
        public string $name,
        public string $status,
        public string $location,
        public string $lastEpisode,
        public string $species,
        public string $origin
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromAPI(array $data): self
    {
        return new self(
            name: $data['name'],
            status: $data['status'],
            location: $data['location']['name'],
            lastEpisode: $data['last_episode'],
            species: $data['species'],
            origin: $data['origin']['name']
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'status' => $this->status,
            'location' => $this->location,
            'last_episode' => $this->lastEpisode,
            'species' => $this->species,
            'origin' => $this->origin
        ];
    }
}
