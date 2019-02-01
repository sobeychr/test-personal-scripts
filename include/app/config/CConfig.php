<?php

namespace App\Config;

class CConfig
{
    protected $config = [];
    protected $name = '';

    public function getConfigs():array
    {
        return $this->config;
    }

    protected function setConfig(array $data):void
    {
        $arr = &$this->config[ $this->name ];
        if(!is_array($arr)) {
            $arr = [];
        }
        $arr = array_merge(
            $arr,
            $data
        );
    }
}