<?php

use Core\Application;
use Core\Request;

require __DIR__.'/../vendor/autoload.php';

$app = new Application();
$app->init()->send();

echo json_encode(Request::setInstance()->getHeader('secChUa'));