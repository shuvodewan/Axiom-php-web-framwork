<?php

namespace App\controllers;

use App\views\render\LandingView;
use Exception;

class HomeController
{
    public function index($request){
        LandingView::init()->render('landings.home');
    }

    public function users($request,$user_id,$id){
        throw new Exception('test');
        echo $user_id;
        echo $id;
    }
}