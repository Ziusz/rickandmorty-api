<?php

namespace App\Contracts;

use App\Models\Character;
use Illuminate\Database\Eloquent\Collection;

interface CharacterRepositoryInterface
{
    public function create(array $data): Character;
}
