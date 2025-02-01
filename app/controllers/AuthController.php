<?php

namespace App\controllers;

use App\views\render\LandingView;
use Exception;
use Facade\Route;

class AuthController
{
    public function registration($request){
        LandingView::init()->render('landings.registration');
    }

}