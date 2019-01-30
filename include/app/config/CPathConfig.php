<?php

namespace App\Config;

use App\Config\CConfig as BaseConfig;

class CPathConfig extends BaseConfig
{
    protected $name = 'path';

    public function __construct()
    {
        $this->setPaths();
    }

    private function setPaths():void
    {
        $config = [
            'ajax'  => 'ajax/',
            'css'   => 'asset/css/',
            'js'    => 'asset/js/',
            'icon'  => 'asset/icon/',
            'image' => 'asset/image/',

            'setup'       => 'include/setup/',
            'setupLayout' => 'include/setup/layout/',
            'setupPage'   => 'include/setup/page/',

            'template' => 'include/view/template/',
            'view'     => 'include/view/',
            'viewLayout' => 'include/view/layout/',
            'viewPage'   => 'include/view/page/',
        ];

        $this->setConfig($config);
    }
}