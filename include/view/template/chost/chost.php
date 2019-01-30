<?php
$cd = 'cd ' . $path;
$docker = 'docker exec -ti '.$exec.'_web_1 bash';
?><article class="chost">
    <h3><?=$title;?></h3>
    <div class="chost__content">
        <input type="text" class="chost__path" readonly value="<?=$path;?>" />
        <input type="text" class="chost__path" readonly value="<?=$docker;?>" />
        <?=$entries;?>
    </div>
</article>