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
        $this->setSeo();
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
                    'blur',
                    'css',
                    'hosts',
                    'men',
                    'parser',
                    'seo',
                    'testlink',
                    'timestamp',
                    'upload',
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
                    'Char List' => [
                        'charList',
                        ['on',  'list'],
                    ],
                    'Cookie' => [
                        'cookieParse',
                        ['off', 'decode'],
                    ],
                    'CSS parser' => [
                        'cssParse',
                        ['on',  'pretty'],
                        ['off', 'minify'],
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
            ],
        ];

        $this->setConfig($config);
    }

    private function setSeo():void
    {
        $linksVideo = $this->_setSeoLinks(
            'videos',
            'videos/all-sites/all-pornstars/all-categories/{time}/{sort}/',
            ['bydate', 'mostrated', 'mostviewed', 'title', 'relevant'],
            ['alltime', 'thisweek', 'thismonth', 'thisyear', 'upcoming']
        );

        $linksModel = $this->_setSeoLinks(
            'pornstars',
            'pornstars/all-pornstars/female/all-categories/any/{sort}/',
            ['recent', 'bypopularity', 'byfollowed', 'numberofvideos', 'name']
        );

        $config = [
            'seo' => [
                'links' => array_merge($linksVideo, $linksModel),
            ],
        ];

        $this->setConfig($config);
    }
    private function _setSeoLinks(string $root, string $url, array $sort=[], array $time=[]):array
    {
        $arr = [$root];
        foreach($sort as $s)
        {
            if(count($time) > 0) {
                foreach($time as $t)
                {
                    $arr[] = fReplace($url, ['{time}' => $t, '{sort}' => $s]);
                }
            }
            else {
                $arr[] = fReplace($url, ['{sort}' => $s]);
            }
        }
        return $arr;
    }
}
