<?php
require_once __DIR__ . '/include/app/CCore.php';

use App\CCore;
use App\Request\CPage;

use App\Functional\CLoad;

$core = new CCore();
$core->asHtml();
/*
$page = new CPage();
$page->renderByRequest();
*/

$tt = CLoad::loadLocalJson('include/setup/layout/default.json');

fLogEcho($tt);
