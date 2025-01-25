<?php

use Core\Application;
use Core\Request;
use Core\Route;

require __DIR__.'/../vendor/autoload.php';

$app = new Application();
$app->boot()->send();
