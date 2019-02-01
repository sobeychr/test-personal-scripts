<?php

namespace App\Output;

use App\CCore;
use App\Functional\CLoad;

class CSetup
{
    public const OMIT = ['css', 'js'];

    protected $layout = '';
    protected $page   = '';

    public function __construct(string $layout, string $page)
    {
        $this->layout = $layout;
        $this->page   = $page;
    }

    public function getLayout():array
    {
        $path = CCore::config(['path','setupLayout']);
        return CLoad::loadLocalJson($path . $this->layout . '.json');
    }

    public function getPage():array
    {
        $path = CCore::config(['path','setupPage']);
        return CLoad::loadLocalJson($path . $this->page . '.json');
    }
}
