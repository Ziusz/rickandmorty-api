<?php

namespace App\DTO;

class CharacterDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $status,
        public readonly string $location,
        public readonly string $lastEpisode,
        public readonly string $species,
        public readonly string $origin
    ) {}

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
