<?php
$source = 'http://www.men.com/scene/{id}';
$inIds = $_POST['ids'] ?? [];

$start = microtime(true);

function findCanonical($html)
{
    $i = strpos($html, 'canonical');
    if($i === false) {
        return '';
    }

    $j = strpos($html, '>', $i + 1);
    if($j === false) {
        return '';
    }

    $cut = substr($html, $i, $j);
    preg_match('/http[^\"]+/', $cut, $match);

    return $match[0] ?? '';
}

$cookies = [
    'RNLBSERVERID' => 'ded1920',
    'ats' => 'eyJhIjo5NDk2LCJjIjoyMTk3MywibiI6MjIsInMiOjIwNiwiZSI6NzI0LCJwIjozfQ==',
    'videoViewLimit' => 3,
];

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_TIMEOUT => 5,

    CURLOPT_COOKIE => http_build_query($cookies, '', '; '),
    CURLOPT_COOKIESESSION => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HEADER => true,
    CURLOPT_NOBODY => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
]);

$results = [];

foreach($inIds as $id)
{
    $url = str_replace('{id}', $id, $source);

    curl_setopt($ch, CURLOPT_URL, $url);
    $exec = curl_exec($ch);
    $info = curl_getinfo($ch);
    //$errno = curl_errno($ch);
    //$error = curl_error($ch);

    $canonical = findCanonical($exec);

    $results[] = [
        'id' => $id,
        'url' => $url,
        'code' => $info['http_code'],
        'canonical' => $canonical,
    ];
}

curl_close($ch);

$duration = microtime(true) - $start;
$duration = substr(
    $duration,
    0,
    min(7, strlen($duration))
);

echo json_encode([
    'duration' => $duration,
    'results' => $results,
]);
