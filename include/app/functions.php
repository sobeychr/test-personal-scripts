<?php

// Returns a filepath from multiple possible extensions
function fGetPath(string $path, array $extensions=[])
{
    if(!$path) {
        throw new Exception('[fGetPath] Unable to load empty path');
    }

    foreach ($extensions as $ext) {
        $relPath = $path . '.' . $ext;
        if(file_exists($relPath)) {
            return $relPath;
        }
    }

    $pathCut = strstr($path, 'include', false);
    throw new Exception('[fGetPath] Unable to get path on set extensions - '.$pathCut.' ; '.implode(', ', $extensions));
}

// Prints out value for debug
function fLogEcho($value, string $label='')
{
    static $g_fLogEcho=false;
    if(!$g_fLogEcho) {
        $g_fLogEcho = [
            '! null'  => null,
            '! false' => false,
            '! true'  => true,
            '! 1' => 1,
            '"1"' => '1',
            '! 0' => 0,
            '"0"' => '0',
        ];
    }

    if($label) {
        $label = '"'.$label.'" - ';
    }

    foreach($g_fLogEcho as $string=>$equivalent)
    {
        if($value === $equivalent) {
            $value = $string;
        }
    }
    
    echo '<pre class="clogs">'.$label.print_r($value, true).'</pre>';
}

// Returns array sub-value  -   $arr['test']['alpha'] == fGetArray($arr, ['test','alpha'])
function fGetArray(array $array, array $path, $default=null)
{
    foreach($path as $entry)
    {
        if(isset($array[$entry])) {
            $array = $array[$entry];
        }
        else {
            return $default;
        }
    }
    return $array;
}

// Easy to read RegExp and String replace
function fReplace(string $string, array $replace, bool $asRegexp=false):string
{
    $func = $asRegexp ? 'preg_replace' : 'str_replace';
    return $func(
        array_keys($replace),
        array_values($replace),
        $string
    );
}
