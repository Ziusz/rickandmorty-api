<?php

namespace App\Http\Controllers\Api\V1\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterFrontAPIResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'location' => $this->location,
            'last_episode' => $this->last_episode,
            'species' => $this->species,
            'origin' => $this->origin,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
