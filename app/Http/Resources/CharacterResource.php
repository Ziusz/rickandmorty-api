<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'status' => $this->status,
            'location' => $this->location,
            'last_episode' => $this->lastEpisode,
            'species' => $this->species,
            'origin' => $this->origin,
        ];
    }
}
