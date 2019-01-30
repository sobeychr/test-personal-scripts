<?php

namespace App\Request;

use App\Core\CCore;

class CSetup
{
    protected $layout = '';
    protected $page   = '';

    public function __construct(string $layout, string $page)
    {
        $this->layout = $layout;
        $this->page   = $page;
    }

    public function getLayout():array
    {
        $path = CCore::config(['path','viewLayout']);
        $filepath = fGetPath($path . $this->layout, ['json']);
        
    }
}
