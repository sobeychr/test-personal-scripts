<?php
use App\CCore;

//$links = CCore::Config(['page', 'index', 'links']);
?>
<main class='main'>
    <section class='input clearfix'>
        <form action='' class='input__form'>
            <div class='btn'>
                <button type='submit' class='btn__submit'>Compare</button>

                <p class='btn-p'>
                    <button type='reset' class='btn__clear-input'>Clear input</button>
                    <button type='button' class='btn__clear-output'>Clear output</button>
                </p>
            </div>

            <article class='old'>
                <h2>Old</h2>
                <textarea></textarea>
            </article>
            <article class='new'>
                <h2>New</h2>
                <textarea></textarea>
            </article>
        </form>
    </section>

    <section class='output clearfix'>
        <article class='old'></article>
        <article class='new'></article>
    </section>
</main>