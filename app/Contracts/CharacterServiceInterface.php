<?php

namespace App\Contracts;

interface CharacterServiceInterface
{
    public function verifyPageParam(int $page): void;
    public function loadCharacters(int $page): array;
}
