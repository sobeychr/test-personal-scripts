<?php

namespace App\Functional;

use Exception;

use App\CCore;
use App\Error\CErrorJson;
use App\Error\CErrorLoad;

abstract class CLoad
{
    static public function loadLocal(string $path):string
    {
        if(!file_exists($path) || is_dir($path)) {
            throw new CErrorLoad($path, 'File not found');
        }

        $file = file_get_contents($path, false, self::getContextLocal());

        if($file === false) {
            throw new CErrorLoad($path, 'Unable load content');
        }

        return $file;
    }

    static public function loadLocalJson(string $path):array
    {
        $string = self::loadLocal($path);
        $array = json_decode($string, true);

        if(!is_array($array)) {
            throw new CErrorJson($path, $string);
        }

        return $array;
    }

    static private $contextLocal = false;
    static private function getContextLocal()
    {
        if(!self::$contextLocal) {
            $config = CCore::config(['context','local']);
            self::$contextLocal = stream_context_create($config);
        }
        return self::$contextLocal;
    }
}
