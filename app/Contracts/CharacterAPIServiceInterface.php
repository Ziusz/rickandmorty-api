<?php

namespace App\Contracts;

interface CharacterAPIServiceInterface
{
    public function getPagesCount(): int;
    public function getCharacters(int $page): array;
    public function getLastEpisodeOfCharacter(array $character): string;
}
