<html>
    <head>
        <title><?=$this->title;?></title>
        <link rel='icon' href='/asset/icon/<?=$this->icon?>.png'>
        <?=$this->css;?>
        <?=$this->js;?>
    </head>
    <?php if($this->showHeader): ?>
        <header class='dheader'>
            <h1 class='dheader__title'>
                <a class='dheader__link' href='/'>&lt;</a>
                <?=$this->title;?>
            </h1>
        </header>
    <?php endif; ?>
    <body>
        <?=$this->body;?>
    </body>
</html>