<?php

use App\CCore;
use Component\CHost;

// List of quick commands
$commands = CCore::config(['page', 'host', 'commands']);
$commandsHtml = array_map(function(string $v):string {
    return '<li><input type="text" readonly value="' . $v . '"/></li>';
}, $commands);

// List of products
$products = CHost::getList();
$productsHtml = array_map(function(CHost $v):string {
    return $v->toHtml();
}, $products);
?>
<main class='main'>
    <h1>Localhost - Hosts</h1>
    <section>
        <h2>Commands</h2>
        <ul class="commands">
            <?= implode('', $commandsHtml); ?>
        </ul>
    </section>
    <section>
        <h2>Search products</h2>
        <input type="search" class="search-input" placeholder="Search entries..." />
    </section>
    <section>
        <h2>Products</h2>
        <?= implode('', $productsHtml); ?>
    </section>
</main>