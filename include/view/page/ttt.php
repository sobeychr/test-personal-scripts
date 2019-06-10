<?php
$cipher = openssl_get_cipher_methods();
$md = openssl_get_md_methods();

$text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mollis venenatis risus at vestibulum. Aliquam a eros sem. Maecenas consequat finibus augue, ac tincidunt dui vestibulum sed. Donec eu metus sit amet ipsum egestas maximus ac sed purus. Aliquam lacus leo, eleifend vel sagittis quis, fermentum sed nisi. Etiam pretium vitae massa non aliquam. Ut tempus ipsum nec magna ultrices dictum. Nunc et risus nec neque euismod pellentesque nec eu nisl. Aliquam quis dui interdum, feugiat lorem sit amet, interdum turpis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce suscipit neque ac sem accumsan pharetra. Sed tempor porttitor augue, a vulputate augue fringilla at.';

$encr = 'aes-256-ccm';
$strings = array_map(function($entry){

    $ivlen = openssl_cipher_iv_length($encr);
    $iv = openssl_random_pseudo_bytes($ivlen);
    return openssl_encrypt($entry, $encr, '', 0, $iv, 4);

}, explode(' ', $text));

?>

<div>
    <h1>Cipher</h1>
    <pre><?= print_r($cipher, true); ?></pre>
    <h1>MD</h1>
    <pre><?= print_r($md, true); ?></pre>
</div>

<div>
    <h1>Strings</h1>
    <pre><?= print_r($strings, true); ?></pre>
</div>