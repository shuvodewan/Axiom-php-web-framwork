<?php

use App\controllers\HomeController;
use Facade\Route;

Route::group(['middleware'=>'web,api'],function(){
    Route::get('/',HomeController::class,'index');
});

