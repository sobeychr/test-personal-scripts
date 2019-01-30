<?php

namespace App\Functional;

use Exception;

use App\Core\CCore;

abstract class CLoad
{
    static public function loadLocal(string $path):string
    {
        if(!file_exists($path) || is_dir($path)) {
            throw new Exception('[CLoad] File not found - '.$path);
        }

        $file = file_get_contents($path, false, self::getContextLocal());

        if($file === false) {
            throw new Exception('[CLoad] Unable fetch file content - '.$path);
        }

        return $file;
    }

    static public function loadLocalJson(string $path):array
    {
        $string = self::loadLocal($path);
        $array = json_decode($string, true);

        if(!is_array($array)) {
            throw new Exception('[CLoad] Unable decode JSON - '.$path);
        }

        return [];
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
