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

        $this->setup = new CSetup($this->page);
        $this->layout = $this->setup->getLayoutName();

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

        $setupLayout = $this->setup->getLayoutJson();
        $setupPage   = $this->setup->getPageJson();

        $this->view = new CView($pathLayout, $pathPage);
        $this->view->setup($this->setup);
        $html = $this->view->render();
        
        die($html);
    }

    public function setPageByRequest():void
    {
        $newPage = substr($this->core->request->getUri(), 1);
        if(($i = strpos($newPage, '?')) !== false) {
            $newPage = substr($newPage, 0, $i);
        }

        if(!$newPage) {
            $newPage = CCore::config(['page', 'default', 'page']);
        }
        $this->page = $newPage;
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
