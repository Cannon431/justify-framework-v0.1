<?php
//Justify Framework v0.1b
define('BASE_DIR', getcwd());
define('TWIG_CACHE_DIR', BASE_DIR . '/framework/cache');

require_once BASE_DIR . '/framework/starter.php';

$app = new Justify;
$app->run();