<?php

namespace App\Request;

use App\CCore;
use App\Request\CRequest;

class CPage
{
    protected const PAGE_EXTS = ['php', 'html'];

    public $layout = 'default';
    public $page   = 'index';

    /** @var \App\CCore */
    protected $core = false;
    /** @var \App\Request\CSetup */
    protected $setup = false;

    public function __construct()
    {
        $this->core = CCore::get();
        $this->core->asHtml();
    }

    public function renderByRequest():void
    {
        $page = $this->setPageByRequest();
        $pathLayout = $this->getLayoutPath();
        $pathPage   = $this->getPagePath();

        if(!$pathLayout) {
            $this->core->header(404, 'Layout not found');
            exit;
        }
        if(!$pathPage) {
            $this->core->header(404, 'Page not found');
            exit;
        }

        //list($title, $css, $js) = $this->getPageSetup($page);

        $this->setup = new CSetup($this->layout, $this->page);

        /*
        ob_start();
        include $pathPage;
        $body = ob_get_contents();
        ob_clean();

        ob_start();
        include $pathLayout;
        $html = ob_get_contents();
        ob_clean();
        die($html);
        */
    }

    public function setPageByRequest():void
    {
        $newPage = substr($this->core->request->getUri(), 1);
        if(!$newPage) {
            $newPage = 'index';
        }
        $this->page = $newPage;
    }

    protected function getLayoutPath():string
    {
        $path = CCore::config(['path','viewLayout']);
        return fGetPath($path . $this->layout, ['php']);
    }

    protected function getPagePath():string
    {
        $path = CCore::config(['path','viewPage']);
        return fGetPath($path . $this->page, self::PAGE_EXTS);
    }

    /*
    protected function getPageSetup(string $page):array
    {
        $return = [];
        $path = P_INCLUDE . 'setup/page/' . $page . '.json';

        if(file_exists($path)) {
            $jsonstr = file_get_contents($path);
            $jsonarr = @json_decode($jsonstr, true);

            $title = $jsonarr['title'] ?? '';
            $css = array_map(function($entry) {
                    return '<link rel="stylesheet" type="text/css" href="/asset/css/'.$entry.'.css">';
                },
                $jsonarr['css'] ?? []
            );
            $js = array_map(function($entry) {
                    return '<script src="/asset/js/'.$entry.'.js"></script>';
                },
                $jsonarr['js'] ?? []
            );

            $return = [
                $title,
                implode("\n", $css),
                implode("\n", $js)
            ];
        }

        return $return;
    }
    */
}
