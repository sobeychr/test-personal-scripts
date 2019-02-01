<?php
require_once __DIR__ . '/include/app/CCore.php';

use App\CCore;
use App\Output\CPage;

$core = new CCore();
$core->asHtml();
$page = new CPage();
$page->renderByRequest();
