<?php

use HefestoMVCLibrary\Router;
use HefestoMVC\database\Connection;


require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../library/bootstrap.php';

$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);