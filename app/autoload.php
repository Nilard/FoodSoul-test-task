<?php

use App\Core\Autoloader;

require_once __DIR__ . '/Core/Autoloader.php';

$loader = new Autoloader;
$loader->register();
$loader->addNamespace('App', __DIR__);
