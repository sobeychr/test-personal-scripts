<?php

namespace App\Output;

use App\CCore;
use App\Output\CSetup;

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

    protected function compileAssets(array $list, bool $isCss=true):string
    {
        $hash = substr(sha1(time()), 0, 6);
        $folder = CCore::config([
            'path',
            $isCss ? 'css' : 'js'
        ]);
        $code = $isCss
            ? '<link rel="stylesheet" type="text/css" href="'.$folder.'{{link}}.css#'.$hash.'">'
            : '<script src="'.$folder.'{{link}}.js#'.$hash.'"></script>';

        $return = array_map(function($entry) use ($code) {
            return fReplace($code, ['{{link}}' => $entry]);
        }, $list);

        return implode("\n", $return);
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

    public function setup(CSetup $csetup):void
    {
        $setupLayout = $csetup->getLayoutJson();
        $setupPage   = $csetup->getPageJson();

        $this->css = $this->compileAssets($setupPage['css'] ?? [], true);
        $this->js  = $this->compileAssets($setupPage['js']  ?? [], false);

        foreach($setupLayout as $key=>$entry)
        {
            if(!in_array($key, CSetup::OMIT)) {
                $this->$key = $entry;
            }
        }
        foreach($setupPage as $key=>$entry)
        {
            if(!in_array($key, CSetup::OMIT)) {
                $this->$key = $entry;
            }
        }
    }

    public function __set(string $name, $value):void
    {
        $this->$name = $value;
    }
}