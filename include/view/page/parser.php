<?php
use App\CCore;

$buttons = CCore::config(['page', 'parser', 'list']);
$probiller = CCore::config(['page', 'parser', 'probiller']);
?>
<aside class='aside'>
    <?php foreach($buttons as $label=>$configs) :
        $func = $configs[0];
        $buttons = array_slice($configs, 1);
    ?>
        <div>
            <p><?=$label;?></p>
            <?php foreach($buttons as $entry) :
                $class = $entry[0];
                $label = $entry[1];
            ?>
                <button type='button' class='<?=$class;?>' data-func='<?=$func;?>'><?=$label;?></button>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    <div>
        <a class='probiller' href='<?=$probiller;?>' target='_blank'>ProBiller</a>
    </div>
</aside>

<div id='popup'>
    <p>
        <span class='function'></span>
        <span class='type'></span>
        <span class='result'></span>
    </p>
    <p class='log'></p>
</div>

<main class='main'>
    <article>
        <h2>input</h2>
        <textarea id='input'></textarea>
    </article>
    <article>
        <h2>output</h2>
        <pre id='output'></pre>
    </article>
</main>
