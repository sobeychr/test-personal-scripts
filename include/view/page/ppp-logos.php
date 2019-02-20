<?php
use App\CCore;

$cssFolder = CCore::Config(['ppplogo', 'cssFolder']);
$json = CCore::Config(['ppplogo', 'json']);
$products = CCore::Config(['ppplogo', 'products']);

$cssList = [];
$cssDir = scandir($cssFolder);
foreach($cssDir as $cssFile)
{
    if(strpos($cssFile, '.css') !== false) {
        $cssList[] = $cssFolder . $cssFile;
    }
}
?>
<aside class='aside'>
    <h1>Select product</h1>
    <ul>
        <?php foreach($products as $entry): ?>
            <li data-product='<?=$entry;?>'><?=$entry;?></li>
        <?php endforeach; ?>
    </ul>
</aside>

<main class='main'>
    <a href='' target='_blank' data-path='<?=$json;?>' class='main__json'>Json path &gt;&gt;</a>

    <section>
        <h1>Network</h1>
        <article class='template'>
            <p>{product}</p>
            <div class='pp-featured-network'>
                <div class='pp-featured-network-logo {product}_bar'></div>
            </div>
        </article>
        <div class='content'></div>
    </section>

    <section>
        <h1>Channels</h1>
        <article class='template'>
            <p>{product}</p>
            <a class="logo-box pp-extras-item-tile" href="#" target="_self">
                <div class="pp-extras-logo {product}_bar"></div>
            </a>
        </article>
        <div class='content'></div>
    </section>
</main>

<footer class='footer'>
    <?php foreach($cssList as $entry): ?>
        <link rel='stylesheet' type='text/css' href='<?=$entry;?>'>
    <?php endforeach; ?>
</footer>
