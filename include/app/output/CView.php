<?php

namespace App\Output;

// use CCore;

class CView
{
    public $body = '';
    public $css = '';
    public $js  = '';

    protected $pathLayout = '';
    protected $pathPage   = '';

    public function __construct(string $pathLayout, string $pathPage)
    {
        $this->pathLayout = $pathLayout;
        $this->pathPage   = $pathPage;
    }

    public function render():string
    {
        ob_start();
        include $this->pathPage;
        $this->body = ob_get_contents();
        ob_end_clean();

        ob_start();
        include $this->pathLayout;
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    public function __set(string $name, $value):void
    {
        $this->$name = $value;
    }
}