<?php

namespace App\Output;

use App\CCore;
use App\functional\CLoad;

abstract class CTemplate
{
    static protected $templates = [];

    static public function get(array $path):string
    {
        $filepath = self::getFilepath($path);

        if(!isset($template[$filepath])) {
            $template[$filepath] = CLoad::loadLocal($filepath);
        }

        return $template[$filepath];
    }


    static public function render(array $path, $data):string
    {
        $filepath = self::getFilepath($path);

        ob_start();
        include $filepath;
        $render = ob_get_contents();
        ob_end_clean();

        return $render;
    }

    static protected function getFilepath(array $path):string
    {
        $filepath = CCore::config(['path', 'template']) . implode('/', $path);
        return $filepath . '.php';
    }
}
