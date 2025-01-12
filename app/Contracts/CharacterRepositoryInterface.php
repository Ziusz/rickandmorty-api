<?php

namespace App\Contracts;

use App\Models\Character;
use Illuminate\Database\Eloquent\Collection;

interface CharacterRepositoryInterface
{
    public function all(): Collection;
    public function create(array $data): Character;
}
