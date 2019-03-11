<?php

namespace Component;

use App\Output\CTemplate;

class CHost
{
    protected const FILE = 'C:/Windows/System32/drivers/etc/hosts';

    protected const LINE_HOST = '##-- ';
    protected const LINE_SUBTITLE = '## ';
    protected const LINE_TITLE = '##== ';
    
    protected const MIN_LENGTH = 3;
    
    protected const TITLE_CUT = ' =';
    
    protected const EXEC = array(
        'BZ' => 'brazzers-docker',
        'DP' => 'digitalplayground_docker',
        'MF' => 'mofos_vde',
        'MN' => 'men-docker',
        'RK' => 'realitykings_vde',
    );
    protected const FOLDER = array(
        'BZ' => 'C:/brazzers-docker/',
        'DP' => 'C:/dev/digitalplayground_docker/',
        'MF' => 'C:/dev/mofos_vde/',
        'MN' => 'C:/men-docker/',
        'RK' => 'C:/dev/realitykings_vde/',
    );

    static public function getList():array
    {
        $filestr = file_get_contents(self::FILE);
        $filearr = explode("\n", $filestr);

        $chost = false;
        $entries  = array();

        foreach($filearr as $line)
        {
            // Trims current line
            $line = trim($line);
            if(strlen($line) < self::MIN_LENGTH) {
                continue;
            }

            // New product
            if(strpos($line, self::LINE_TITLE) === 0) {
                if($chost) {
                    $entries[] = $chost;
                }

                $chost = new CHost($line);
            }

            // Adding an entry or subtitle to current product
            elseif($chost) {
                if(strpos($line, self::LINE_SUBTITLE) === 0) {
                    $chost->addSubtitle($line);
                }
                elseif(strpos($line, self::LINE_HOST) === 0) {
                    $chost->setHost($line);
                }
                else {
                    $chost->addEntry($line);
                }
            }
        }

        if($chost) {
            $entries[] = $chost;
        }

        usort($entries, 'self::sortList');
        return $entries;
    }

    static protected function sortList(CHost $a, CHost $b):int
    {
        return strcmp($a->title, $b->title);
    }

    static protected function lineToLink(string $line):string
    {
        $link = substr(strstr($line, ' ', false), 1);
        $links = explode(' ', $link);
        
        //$template = CTemplate::get(['chost','entry']);

        $html = array_map(function($url) {
            return '<a href="//'.$url.'" target="_blank" class="chost__link">'.$url.'</a>';
        }, $links);
        
        return implode('', $html);
    }

    protected $currentSubtitle = '';
    protected $entries = array();
    protected $host  = '';
    protected $lines = array();
    protected $title = '';

    public function __construct(string $titleline)
    {
        $this->lines[] = $titleline;

        $title = fReplace($titleline, array(self::LINE_TITLE=>''));
        $title = strstr($title, self::TITLE_CUT, true);
        $this->title = $title;
    }

    // ================================================================
    // Populates the current CHost
    protected function addEntry(string $line):void
    {
        $this->lines[] = $line;

        if($this->currentSubtitle) {
            $this->entries[$this->currentSubtitle][] = $line;
        }
        else {
            $this->entries[] = $line;
        }
    }
    protected function addSubtitle(string $line):void
    {
        $this->lines[] = $line;

        $subtitle = fReplace($line, array(self::LINE_SUBTITLE=>''));
        $this->currentSubtitle = $subtitle;
        $this->entries[$subtitle] = array();
    }
    protected function setHost(string $line):void
    {
        $this->lines[] = $line;
        $this->host = fReplace($line, array(self::LINE_HOST=>''));
    }

    // ================================================================
    // Compile entries
    protected function compileEntries():string
    {
        $urls = array_map('self::lineToLink', $links);

        return '<div class="chost__subtitle">
    <p class="chost__subtitle__text"></p>
    '.implode('', $urls).'
</div>';
    }
    protected function compileSubtitles():string
    {
        $html = array();
        foreach($this->entries as $subtitle => $links)
        {
            $urls = array_map('self::lineToLink', $links);

            $html[] = '<div class="chost__subtitle">
    <p class="chost__subtitle__text">'.$subtitle.'</p>
    '.implode('', $urls).'
</div>';
        }
        return implode('', $html);
    }

    // ================================================================
    protected function getExec():string
    {
        return self::EXEC[$this->host] ?? '';
    }
    protected function getPath():string
    {
        return self::FOLDER[$this->host] ?? '';
    }

    // ================================================================
    public function toHtml():string
    {
        $entries = $this->currentSubtitle
            ? $this->compileSubtitles()
            : $this->compileEntries();

        return '<article class="chost">
    <h3>'.$this->title.'</h3>
    <div class="chost__content">
        <input type="text" class="chost__path" readonly value="cd '.$this->getPath().'"" />
        <input type="text" class="chost__path" readonly value="docker exec -ti '.$this->getExec().'_web_1 bash" />
        '.$entries.'
    </div>
</article>';
    }
}