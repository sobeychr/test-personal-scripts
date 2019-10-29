<?php

use App\CCore;

$domains = CCore::config(['page', 'seo', 'domains']);
$domainsHtml = array_map(function(string $v):string {
    return '<option value="' . $v . '"/>';
}, $domains);

$links = CCore::config(['page', 'seo', 'links']);
$linksHtml = array_map(function(string $v):string {
    return '<input type="text" value="' . $v . '" placeholder="// URL">';
}, $links);
// $linksHtml = [];
?>
<main class='main'>
    <div id='blocker' class='hidden'>
        <span></span>
    </div>

    <form action='' method='post'>
        <input type='text' value='' id='domain' placeholder='// domain' list='domains'/>
        <datalist id='domains'>
            <?= implode('', $domainsHtml); ?>
        </datalist>

        <div class='urls'>
            <p class='buttons'>
                <button type='button' class='add'>Add</button>
                <button type='submit' class='send'>Send</button>
            </p>

            <div id='results'>
                <div class='entry template'>
                    <p class='fullurl'>{fullurl}</p>
                    <p class='url'>{url}</p>
                    <p class='title'>{title}</p>
                    <p class='robots'>{robString}</p>
                </div>
            </div>

            <div id='list'>
                <input type='text' class='template' value='' placeholder='// URL'>
                <?= implode('', $linksHtml); ?>
            </div>
        </div>
    </form>
</main>
