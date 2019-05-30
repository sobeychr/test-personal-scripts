<?php
$imgs = $_POST['imgs'] ?? [];

$time = time();
$extensions = ['jpg', 'gif', 'png'];

$dirSrc = './../blur-img/src/';
$dirDist = './../blur-img/dist/' . date('Y-m-d-H-i-s', $time) . '/';

mkdir($dirDist);

foreach($imgs as $img)
{
    $newImg = imagecreatefromjpeg($dirSrc . $img);
    imagefilter($newImg, IMG_FILTER_PIXELATE, 6);
    //imagefilter($newImg, IMG_FILTER_GAUSSIAN_BLUR);
    //imagefilter($newImg, IMG_FILTER_SELECTIVE_BLUR);
    imagejpeg($newImg, $dirDist . $img);
}

usleep(250);

$images = array_filter(scandir($dirDist), function($entry) use ($extensions){
    $ext = substr($entry, -3);
    return in_array($ext, $extensions);
});

echo json_encode([
    'time' => $time,
    'dir' => $dirDist,
    'src' => $imgs,
    'images' => array_values($images),
]);
