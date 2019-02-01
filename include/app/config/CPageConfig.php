<?php

namespace App\Config;

use App\Config\CConfig as BaseConfig;

class CPageConfig extends BaseConfig
{
    protected $name = 'page';

    public function __construct()
    {
        $this->setParser();
    }

    private function setParser():void
    {
        $config = [
            'parser' => [
                'Char Codes' => [
                    'charCodes',
                    ['on',  'on'],
                    ['off', 'off'],
                ],
                'Base 64' => [
                    'base64Encode',
                    ['on',  'on'],
                    ['off', 'off'],
                ],
                'JSON' => [
                    'jsonParse',
                    ['on',  'pretty'],
                    ['off', 'minify'],
                ],
                'URL' => [
                    'urlParse',
                    ['on',  'encode'],
                    ['off', 'decode'],
                ],
                'Cookie' => [
                    'cookieParse',
                    ['off', 'decode'],
                ],
                'GET parameter' => [
                    'getParse',
                    ['off', 'decode'],
                ],
            ],
        ];

        $this->setConfig($config);
    }
}