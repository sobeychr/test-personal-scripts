<?php

namespace App\Config;

use App\Config\CConfig as BaseConfig;

class CEnvConfig extends BaseConfig
{
    const FILE = '.env';

    protected $name = 'env';

    public function __construct()
    {
        $this->setEnvironment();
    }

    private function setEnvironment():void
    {
        $config = [];

        if(file_exists(self::FILE)) {
            $array = parse_ini_file(self::FILE, true);
            if(is_array($array)) {
                $config = $array;
            }
        }

        $this->setConfig($config);
    }
}