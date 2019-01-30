<?php
$links = [
    'hosts',
    'parser',
    'timestamp',
];
?>
<main class='main'>
    <h1 class='main__title'></h1>
    <div>
        <?php foreach($links as $entry): ?>
        <a href='/<?=$entry;?>'><?=$entry;?></a>
        <?php endforeach; ?>
    </div>
</main>