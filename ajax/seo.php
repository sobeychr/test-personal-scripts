<?php
$domain = $_POST['domain'] ?? '';
$urls = $_POST['urls'] ?? '';
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => 'Cookie: iAgree=1',
        'timeout' => 3,
    ],
]);

$robots = [];

foreach($urls as $url)
{
    $fullurl = $domain . $url;
    $content = @file_get_contents($fullurl, false, $context) ?? '';

    $robString = '404, no robots';
    $title = '404, no title';

    if($content) {
        $robString = strstr($content, '<meta name="robots', false);
        $robString = strstr($robString, '>', true) . '>';

        $title = strstr($content, '<title', false);
        $title = strstr($title, '</title>', true) . '</title>';
    }

    $robots[] = [
        'fullurl' => $fullurl,
        'url' => $url,
        'robString' => htmlentities($robString),
        'title' => htmlentities($title),
    ];
}

echo json_encode([
    'domain' => $domain,
    'urls' => $urls,
    'robots' => $robots,
]);
