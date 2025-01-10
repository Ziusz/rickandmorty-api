<?php

namespace App\Repositories;

use App\Contracts\CharacterRepositoryInterface;
use App\Models\Character;
use Illuminate\Database\Eloquent\Collection;

class CharacterRepository implements CharacterRepositoryInterface
{
    /**
     * @return Collection<int, Character>
     */
    public function getAll(): Collection {
        return Character::all();
    }

    /**
     * @param array<string, mixed> $data
     * @return Character
     */
    public function create(array $data): Character {
        return Character::create($data);
    }
}
