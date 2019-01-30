<?php

namespace App\Error;

use Exception;

use App\CCore;

class CErrorLoad extends Exception
{
    protected $message = '';

    public function __construct(string $path, string $message, $details=null)
    {
        $this->message = $message.' - '.$path;
        if($details) {
            $this->message .= '<pre>'.$details.'</pre>';
        }
    }
}
