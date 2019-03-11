<?php
use App\CCore;
use App\output\CTemplate;

$links = CCore::Config(['page', 'index', 'links']);
$linksHtml = [];

foreach($links as $entry)
{
    $linksHtml[] = CTemplate::render(['index', 'link'], $entry);
}
?>
<main class='main clearfix'>
    <h1 class='main__title'></h1>
    <nav>
        <?= implode('', $linksHtml); ?>
    </nav>
</main>