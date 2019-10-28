<?php
//$dir = scandir('./asset/data/');
$fileStr = file_get_contents('./asset/data/p1-gateway-paths.txt');
$arr = explode("\n", $fileStr);
$queries = [];

$q = 0;
foreach($arr as $line)
{
    $adstart = strpos($line, 'ad_id=');
    if($adstart === false) {
        continue;
    }
    $adend = strpos($line, '&', $adstart);
    if($adend === false) {
        continue;
    }

    $adstr = substr($line, $adstart, $adend - $adstart);
    if(!in_array($adstr, $queries)) {
        $queries[] = $adstr;
    }
}

sort($queries);

?>
<main><pre><?= implode("\n", $queries); ?></pre></main>