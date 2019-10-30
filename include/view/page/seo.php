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
                <p class='entry template'>
                    <span class='fullurl'>{fullurl}</span>
                    <br/><span class='url'>{url}</span>
                    <br/><span class='title'>{title}</span>
                    <br/><span class='robots'>{robString}</span>
                </p>
            </div>

            <div id='list'>
                <input type='text' class='template' value='' placeholder='// URL'>
                <?= implode('', $linksHtml); ?>
            </div>
        </div>
    </form>
</main>
