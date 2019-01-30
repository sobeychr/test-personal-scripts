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
        $this->config[ $this->name ] = $data;
    }
}