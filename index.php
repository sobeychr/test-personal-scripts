<?php
require_once __DIR__ . '/include/app/core/CCore.php';

use App\Core\CCore;
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
