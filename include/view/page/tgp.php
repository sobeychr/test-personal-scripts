<?php
use App\CCore;

function getRandomLink()
{
    static $g_getRandomLink = [];
    if(empty($g_getRandomLink)) {
        $g_getRandomLink = CCore::Config(['page', 'tgp', 'links']);
        shuffle($g_getRandomLink);
    }
    return array_pop($g_getRandomLink);
}
?>
<main class='main'>
    <?php for($col=0; $col<4; $col++): ?>
    <div class='col'>
        <?php for($img=0; $img<7; $img++): ?>
        <a class='entry entry-<?=rand(1,7);?>' href='<?=getRandomLink();?>'></a>
        <?php endfor; ?>
    </div>
    <?php endfor; ?>
</main>