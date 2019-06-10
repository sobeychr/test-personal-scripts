<?php
use App\CCore;
?>

<main class='main clearfix'>
    <h1>Men IDs</h1>
    <form action='' id='form' method='post'>
        <label for='input'>Input IDs <i>split entries by new lines</i></label>
        <p>
            <button type='reset'>Clear</button>
            <button type='submit'>Send</button>
        </p>
        <textarea id='input'></textarea>
    </form>

    <div id='output'>
        <p class='duration'></p>
        <div class='entry template'>
            <p>
                <span class='id'>{id}</span>
                <span class='alt {alt-class}'>{alt}</span>
                <span class='title'>{title}</span>
            </p>
            <p class='code {code-class}'>{code}</p>
            <p class='sent'>{sent}</p>
            <p class='received'>{received}</p>
        </div>
    </div>
</main>
