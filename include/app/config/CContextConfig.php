<?php

namespace App\Config;

use App\Config\CConfig as BaseConfig;

class CContextConfig extends BaseConfig
{
    protected $name = 'context';

    public function __construct()
    {
        $this->setLocal();
    }

    private function setLocal():void
    {
        $config = [
            'local' => [
                'http' => [
                    'follow_location' => 0,
                    'header' => 'Contetx-type: text/plain',
                    'max_redirects' => 1,
                    'method' => 'GET',
                    'timeout' => 1,

                ],
            ],
        ];

        $this->setConfig($config);
    }
}