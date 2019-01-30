<?php

namespace App\Config;

use App\Config\CConfig as BaseConfig;

class CHostConfig extends BaseConfig
{
    protected $name = 'host';

    public function __construct()
    {
        $this->setFolders();
    }

    private function setFolders():void
    {
        $config = [
            'bz' => [
                'docker' => 'brazzers-docker',
                'folder' => 'brazzers-docker',
            ],
            'dp' => [
                'docker' => 'digitalplayground_docker',
                'folder' => 'dev/digitalplayground_docker',
            ],
            'mf' => [
                'docker' => 'digitalplayground_docker',
                'folder' => 'dev/digitalplayground_docker',
            ],
            'mn' => [
                'docker' => 'men-docker',
                'folder' => 'men-docker',
            ],
            'rk' => [
                'docker' => 'realitykings_vde',
                'folder' => 'dev/realitykings_vde',
            ],
        ];

        $this->setConfig($config);
    }
}