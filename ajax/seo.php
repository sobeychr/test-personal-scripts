<?php
$domain = $_POST['domain'] ?? '';
$urls = $_POST['urls'] ?? '';
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => 'Cookie: iAgree=1',
        'timeout' => 1,
    ],
]);

$robots = [];

foreach($urls as $url)
{
    $fullurl = $domain . $url;
    $content = file_get_contents($fullurl, false, $context);
    $robString = strstr($content, '<meta name="robots', false);
    $robString = strstr($robString, '>', true);

    $robots[] = [
        'fullurl' => $fullurl,
        'url' => $url,
        'robString' => $robString,
    ];
}

echo json_encode([
    'domain' => $domain,
    'urls' => $urls,
    'robots' => $robots,
]);
