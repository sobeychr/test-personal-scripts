<?php

namespace App\Error;

use Exception;

use App\CCore;

class CErrorJson extends Exception
{
    protected $message = '';

    public function __construct(string $path, string $jsonstring='')
    {
        $this->message = 'Unable decode JSON, '.json_last_error_msg().' - '.$path;
        if($jsonstring) {
            $core = CCore::get();

            if($core->isHtml) {
                $this->message .= '<pre>'.print_r($jsonstring,true).'</pre>';
            }
            else {
                $this->message .= "\n".print_r($jsonstring,true);
            }
        }
    }
}
