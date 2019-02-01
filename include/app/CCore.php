<?php

namespace App;

use App\Error\CErrorCore;
use App\Error\CErrorHandler;
use App\Functional\CRequest;

require_once __DIR__ . '/functions.php';

class CCore
{
    /** @var \App\CCore */
    static protected $instance = false;
    static public function get():CCore
    {
        return self::$instance;
    }

    static public function config(array $path, $default=null)
    {
        return self::$instance->getConfig($path, $default);
    }

    static public function request():CRequest
    {
        return self::$instance->request;
    }

    // array_merge() of \App\Config\CConfig
    protected $configs = [];

    protected $isHtml = false;
    protected $isJson = false;
    protected $isText = true;

    /** @var \App\error\CErrorHandler */
    protected $error = false;
    /** @var \App\Request\CRequest */
    protected $request = false;

    public function __construct()
    {
        self::$instance = $this;
        $this->init();
    }

    public function __get($propertyName)
    {
        if(!is_string($propertyName)) {
            throw new CErrorCore('Unable to get non-string property - '.$propertyName);
        }
        if(property_exists($this, $propertyName)) {
            return $this->$propertyName;
        }

        throw new CErrorCore('Unable to get CCore property $this->'.$propertyName);
    }

    public function asHtml():void
    {
        $this->isHtml = true;
        $this->isJson =
        $this->isText = false;

        header('Content-type: text/html; text/plain; charset=utf-8');
    }
    public function asJson():void
    {
        $this->isJson = true;
        $this->isHtml =
        $this->isText = false;

        header('Content-type: application/json; text/plain; charset=utf-8');
    }
    public function asText():void
    {
        $this->isText = true;
        $this->isHtml =
        $this->isJson = false;

        header('Content-type: text/plain; charset=utf-8');
    }

    private function init():void
    {
        error_reporting(E_ALL);
        spl_autoload_register([$this, 'autoLoader']);

        $this->error = new CErrorHandler($this);

        set_error_handler([$this->error, 'error'], E_ALL);
        set_exception_handler([$this->error, 'exception']);

        $this->request = new CRequest();
    }

    public function getConfig(array $path, $default=null)
    {
        $first = $path[0];

        if(!isset($this->configs[$first])) {
            $class = 'App\Config\C' . ucfirst($first) . 'Config';

            $newConfig = new $class();
            $this->configs = array_merge(
                $this->configs,
                $newConfig->getConfigs()
            );
        }

        return fGetArray($this->configs, $path, $default);
    }

    public function header(int $code, string $details):void
    {
        $protocol = $this->request->getProtocol();
        header($protocol . ' '. $code . ' ' . $details, true, $code);
    }

    private function autoLoader(string $class):void
    {
        $path = __DIR__ . '/../' . $class . '.php';

        if(!file_exists($path)) {
            throw new CErrorCore('Unable to find class path - ' . $class . ' - ' . $path);
        }

        require_once $path;
    }
}
