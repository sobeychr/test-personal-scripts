<?php

namespace App\Output;

use Exception;

use App\CCore;
use App\Functional\CRequest;
use App\Output\CSetup;
use App\Output\CView;

class CPage
{
    protected const PAGE_EXTS = ['php', 'html'];

    public $layout = 'default';
    public $page   = 'index';

    protected $debug = false;

    /** @var \App\CCore */
    protected $core = false;
    /** @var \App\Output\CSetup */
    protected $setup = false;
    /** @var \App\Output\CView */
    protected $view = false;

    public function __construct()
    {
        $this->core = CCore::get();
        $this->core->asHtml();

        $isDebug = CCore::config(['env', 'APP_DEBUG']);
        $isLocal = CCore::config(['env', 'APP_ENV']);
        $this->debug = $isDebug || $isLocal;
    }

    public function renderByRequest():void
    {
        $this->setPageByRequest();
        list($pathLayout, $pathPage) = $this->getRequestPaths();

        if(!file_exists($pathLayout) || !file_exists($pathPage)) {
            if($this->debug) {
                fLogEcho([
                    '$pathLayout' => $pathLayout,
                    '$pathPage' => $pathPage,
                ]);
            }

            $this->core->header(404, 'Page not found');
            exit;
        }

        list($setupLayout, $setupPage) = $this->getSetup();

        $this->view = new CView($pathLayout, $pathPage);
        $this->view->css = $this->compileAssets($setupPage['css'] ?? [], true);
        $this->view->js  = $this->compileAssets($setupPage['js']  ?? [], false);

        foreach($setupLayout as $key=>$entry)
        {
            if(!in_array($key, CSetup::OMIT)) {
                $this->view->$key = $entry;
            }
        }
        foreach($setupPage as $key=>$entry)
        {
            if(!in_array($key, CSetup::OMIT)) {
                $this->view->$key = $entry;
            }
        }
        
        $html = $this->view->render();
        die($html);
    }

    public function setPageByRequest():void
    {
        $newPage = substr($this->core->request->getUri(), 1);
        if(!$newPage) {
            $newPage = 'index';
        }
        $this->page = $newPage;
    }

    protected function compileAssets(array $list, bool $isCss=true):string
    {
        $folder = CCore::config([
            'path',
            $isCss ? 'css' : 'js'
        ]);
        $code = $isCss
            ? '<link rel="stylesheet" type="text/css" href="'.$folder.'{{link}}.css">'
            : '<script src="'.$folder.'{{link}}.js"></script>';

        $return = array_map(function($entry) use ($code) {
            return fReplace($code, ['{{link}}' => $entry]);
        }, $list);

        return implode("\n", $return);
    }

    protected function getRequestPaths():array
    {
        $layout = fGetPath(
            CCore::config(['path', 'viewLayout']) . $this->layout,
            self::PAGE_EXTS
        );
        $page = fGetPath(
            CCore::config(['path', 'viewPage']) . $this->page,
            self::PAGE_EXTS
        );

        return [$layout, $page];
    }

    protected function getSetup():array
    {
        $this->setup = new CSetup($this->layout, $this->page);

        try {
            $layout = $this->setup->getLayout();
            $page   = $this->setup->getPage();
        }
        catch(Exception $except) {
            if($this->debug) {
                $this->core->error->exception($except);
            }

            $this->core->header(404, 'Page not found');
            exit;
        }

        return [$layout, $page];
    }
}
