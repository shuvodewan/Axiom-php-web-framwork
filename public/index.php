<?php

use Core\Application;

require __DIR__.'/../vendor/autoload.php';



var_dump((new Application())->value);

var_dump(Application::getInstance()->value);