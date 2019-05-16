<?php

namespace App\Config;

use App\Config\CConfig as BaseConfig;

class CPageConfig extends BaseConfig
{
    protected $name = 'page';

    public function __construct()
    {
        $this->setDefault();

        $this->setHost();
        $this->setIndex();
        $this->setParser();
    }

    private function setDefault():void
    {
        $config = [
            'default' => [
                'layout' => 'default',
                'page'   => 'index',
            ],
        ];

        $this->setConfig($config);
    }

    private function setHost():void
    {
        $config = [
            'host' => [
                'commands' => [
                    'docker ps -a',
                    'docker-compose up -d',
                    'docker-compose up -d --build',
                    'docker-compose down',
                ],
            ],
        ];

        $this->setConfig($config);
    }

    private function setIndex():void
    {
        $config = [
            'index' => [
                'links' => [
                    'css',
                    'hosts',
                    'parser',
                    'timestamp',
                ],
            ],
        ];

        $this->setConfig($config);
    }

    private function setParser():void
    {
        $config = [
            'parser' => [
                'list' => [
                    'Base 64' => [
                        'base64Encode',
                        ['on',  'on'],
                        ['off', 'off'],
                    ],
                    'Char Codes' => [
                        'charCodes',
                        ['on',  'on'],
                        ['off', 'off'],
                    ],
                    'Cookie' => [
                        'cookieParse',
                        ['off', 'decode'],
                    ],
                    'JSON' => [
                        'jsonParse',
                        ['on',  'pretty'],
                        ['off', 'minify'],
                    ],
                    'GET parameter' => [
                        'getParse',
                        ['off', 'decode'],
                    ],
                    'HTML parser' => [
                        'htmlParse',
                        ['on',  'pretty'],
                        ['off', 'minify'],
                    ],
                    'URL' => [
                        'urlParse',
                        ['on',  'encode'],
                        ['off', 'decode'],
                    ],
                ],
                'probiller' => 'https://probiller.com/mcp/tools/crypt',
            ],
        ];

        $this->setConfig($config);
    }
}