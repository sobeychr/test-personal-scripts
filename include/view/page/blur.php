<?php
$extensions = ['jpg', 'gif', 'png'];

$dirSrc = './blur-img/src/';
$images = array_filter(scandir($dirSrc), function($entry) use ($extensions){
    $ext = substr($entry, -3);
    return in_array($ext, $extensions);
});

$list = [];
foreach($images as $img)
{
    $list[] = '<label data-img="'.$dirSrc.$img.'">
        <input type="checkbox" name="imgs" value="'.$img.'"/>
        '.$img.'
    </label>';
}
?>
<main class='main clearfix'>
    <h1 class='main__title'>Blur</h1>

    <form action='' method='post' id='form'>
        <button type='button' class='on'>Select all</button>
        <button type='button' class='off'>Unselect all</button>

        <button type='submit'>Send</button>
        <?= implode('', $list); ?>
    </form>

    <div id='results'>
        <div class='entry template'>
            <p class='time'>{time}</p>
            <p class='result'>
                {percent}%
                <i>{countInit}&#47;{countEnd}</i>
            </p>
            <div class='imgs'></div>
        </div>
    </div>

    <img src='' id='preview' />
</main>