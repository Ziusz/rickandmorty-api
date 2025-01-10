<?php

namespace App\Exceptions;

use Exception;

class DuplicateCharacterException extends Exception
{
    public function __construct()
    {
        parent::__construct("This character already exist in the database!");
    }
}
