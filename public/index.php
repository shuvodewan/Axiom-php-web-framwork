<?php

use Core\Application;

require __DIR__.'/../vendor/autoload.php';

$app = new Application();
$app->boot()->send();
