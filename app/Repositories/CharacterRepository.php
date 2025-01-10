<?php

namespace App\Repositories;

use App\Models\Character;
use Illuminate\Database\Eloquent\Collection;

class CharacterRepository
{
    public function getAll(): Collection {
        return Character::all();
    }

    public function create(array $data): Character {
        return Character::create($data);
    }
}
