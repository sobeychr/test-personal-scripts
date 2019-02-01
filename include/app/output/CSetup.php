<?php

namespace App\Output;

use App\CCore;
use App\Functional\CLoad;

class CSetup
{
    public const OMIT = ['layout', 'css', 'js'];

    protected $layoutJson = false;
    protected $layoutName = '';

    protected $pageJson = false;
    protected $pageName = '';

    public function __construct(string $page)
    {
        $this->pageName = $page;
    }

    public function getLayoutJson():array
    {
        if(!$this->layoutJson) {
            $layout = $this->getLayoutName();
            $path  = CCore::config(['path','setupLayout']);
            $this->layoutJson = CLoad::loadLocalJson($path . $layout . '.json');
        }
        return $this->layoutJson;
    }

    public function getLayoutName():string
    {
        if(!$this->layoutName) {
            $json = $this->getPageJson();
            $this->layoutName = $json['layout'] ?? CCore::config(['page', 'default', 'layout']);
        }
        return $this->layoutName;
    }

    public function getPageJson():array
    {
        if(!$this->pageJson) {
            $path = CCore::config(['path','setupPage']);
            $this->pageJson = CLoad::loadLocalJson($path . $this->pageName . '.json');
        }
        
        return $this->pageJson;
    }
}
