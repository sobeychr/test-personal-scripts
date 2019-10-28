<?php

use App\CCore;
$domains = CCore::config(['page', 'seo', 'domains']);
$domainsHtml = array_map(function(string $v):string {
    return '<option value="' . $v . '"/>';
}, $domains);
?>
<main class='main'>
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

            <pre id='results'></pre>

            <div id='list'>
                <input type='text' class='template' value='' placeholder='// URL'>
            </div>
        </div>
    </form>
</main>
