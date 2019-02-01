<html>
    <head>
        <title><?=$this->title;?></title>
        <link rel='icon' href='/asset/icon/<?=$this->icon?>.png'>
        <?=$this->css;?>
        <?=$this->js;?>
    </head>
    <?php if($this->showHeader): ?>
        <header>
            <h1><?=$this->title;?></h1>
            <a href='/'>&lt;</a>
        </header>
    <?php endif; ?>
    <body>
        <?=$this->body;?>
    </body>
</html>