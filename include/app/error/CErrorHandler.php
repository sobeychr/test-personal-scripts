<?php

namespace App\Error;

use Throwable;

use App\CCore;

class CErrorHandler
{
    protected $type = '';

    public function error(int $code, string $message, string $file='', int $line=0, array $trace=[]):void
    {
        $this->type = 'Error';
        $this->handler(
            $code,
            $message,
            $file,
            $line,
            $trace
        );
    }

    public function exception(Throwable $error):void
    {
        $this->type = get_class($error);
        $this->handler(
            $error->getCode(),
            $error->getMessage(),
            $error->getFile(),
            $error->getLine(),
            $error->getTrace()
        );
    }

    protected function handler(int $code, string $message, string $file='', int $line=0, array $trace=[]):void
    {
        $str = '';

        $core = CCore::get();
        $traceCount = count($trace);

        if($core->isHtml) {
            $str = '<div class="ccore-error">
    <h1 class="ccore-error__type">'.$this->type.'</h1>
    <p class="ccore-error__p">
        <span class="error__root__string">'.$message.'</span>
    </p>
    <p class="ccore-error__p">
        <span class="error__source__file">'.$file.'</span>
        <span class="error__source__line">'.$line.'</span>
    </p>
    <p class="ccore-error__p">
        <pre class="ccore-error__array">('.$traceCount.') '.print_r($trace, true).'</pre>
    </p>
</div>';
        }
        elseif($core->isJson) {
            $str = json_encode([
                'code' => $code,
                'file' => $file,
                'line' => $line,
                'message' => $message,
                'trace' => $trace,
                'traceCount' => $traceCount,
                'type' => $this->type,
            ]);
        }
        else {
            $str = "\n\n" . $this->type . ' - '
                . 'code: ' . $code
                . ', message: ' . $message
                . "\n\n"
                . 'file: ' . $file
                . ', line: ' . $line
                . "\n\n"
                . '('.$traceCount.') '
                . print_r($trace, true);
        }

        $core->header(500, $this->type);
        die($str);
    }
}
