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
            $path  = CCore::config(['path','setupLayout']);
            $defaultJson = CLoad::loadLocalJson($path . '_default.json');

            $layout = $this->getLayoutName();
            $this->layoutJson = array_merge(
                $defaultJson,
                CLoad::loadLocalJson($path . $layout . '.json')
            );
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
            $defaultJson = CLoad::loadLocalJson($path . '_default.json');

            $this->pageJson = array_merge(
                $defaultJson,
                CLoad::loadLocalJson($path . $this->pageName . '.json')
            );
        }
        return $this->pageJson;
    }
}
