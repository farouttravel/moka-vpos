<?php
include_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function env($name)
{
    return isset($_ENV[$name]) ? $_ENV[$name] : null;
}

global $app;

$app = new \Vpos\Core();

$app->checkRedirect();

include_once './layout/main.php';