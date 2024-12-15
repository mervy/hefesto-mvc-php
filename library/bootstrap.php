<?php


use Dotenv\Dotenv;
use HefestoMVC\helpers\SessionHelper;

ini_set("display_errors", 1);
error_reporting(E_ALL);

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

SessionHelper::startSession();

require __DIR__. '/../library/web.php';