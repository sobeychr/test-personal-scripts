<?php

namespace App\Request;

class CRequest
{
    public const PROTOCOL_NOT_SECURE = 'HTTP/1.1';

    protected const METHOD_GET  = 'GET';
    protected const METHOD_POST = 'POST';

    protected $isAjax  = false;
    protected $isHttps = false;

    protected $host = '';
    protected $method = '';
    protected $name = '';
    protected $port = 0;
    protected $protocol = '';
    protected $time = 0;
    protected $uri = '';

    public function __construct()
    {
        $this->host   = $_SERVER['HTTP_HOST'] ?? '';
        $this->method = $_SERVER['REQUEST_METHOD'] ?? self::METHOD_GET;
        $this->name = $_SERVER['SERVER_NAME'] ?? '';
        $this->port = $_SERVER['SERVER_PORT'] ?? '';
        $this->protocol = $_SERVER['SERVER_PROTOCOL'] ?? self::PROTOCOL_NOT_SECURE;
        $this->time     = $_SERVER['REQUEST_TIME_FLOAT']
            ?? $_SERVER['REQUEST_TIME']
            ?? time();
        $this->uri = $_SERVER['REQUEST_URI'] ?? '/';
    }

    public function getProtocol():string
    {
        return $this->protocol;
    }

    public function getTime(bool $asString=true):float
    {
        return $asString
            ? date('Y-m-d H:i:s', $this->time)
            : $this->time;
    }

    public function getUri():string
    {
        return $this->uri;
    }

    public function isAjax():bool
    {
        return false;
    }

    public function isGet():bool
    {
        return $this->isMethod(self::METHOD_GET);
    }

    public function isPost():bool
    {
        return $this->isMethod(self::METHOD_POST);
    }

    public function isSecure():bool
    {
        return strpos($this->getProtocol(), 'HTTPS') !== false;
    }

    private function isMethod(string $method):bool
    {
        return strpos($this->method, $method) !== false;
    }
}