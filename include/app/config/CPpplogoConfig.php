<?php

namespace App\Config;

use App\Config\CConfig as BaseConfig;

class CPppLogoConfig extends BaseConfig
{
    protected $name = 'ppplogo';

    public function __construct()
    {
        $this->setPaths();
    }

    private function setPaths():void
    {
        $config = [
            'json'  => '//localhost:8080/asset/json/ppp-logo/{product}.json',
            //'json'  => '//web.ppp.local/utilities/products/pornportal/{product}?cdn=default',
            'products' => ['dfn', 'gan', 'php'],

            'cssFolder' => './asset/css-cache/ppp-logo/',
        ];

        $this->setConfig($config);
    }
}