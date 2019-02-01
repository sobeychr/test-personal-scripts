<?php

namespace App\Error;

use Exception;

use App\CCore;

class CErrorCore extends Exception
{
    public function __construct(string $message='')
    {
        $this->message = '[CCore] - ' . $message;
    }
}