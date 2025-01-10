<?php

namespace App\Exceptions;

use Exception;

class RickAndMortyAPIException extends Exception
{
    public function __construct()
    {
        parent::__construct('Rick and Morty API is not responding. Please try again later!');
    }
} 