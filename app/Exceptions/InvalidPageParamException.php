<?php

namespace App\Exceptions;

use Exception;

class InvalidPageParamException extends Exception
{
    public function __construct(int $maxPage)
    {
        parent::__construct("Page parameter must be a number greater than 0 and less than {$maxPage}!");
    }
}
