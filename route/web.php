<?php

use App\controllers\AuthController;
use App\controllers\HomeController;
use Facade\Route;

//Route doesn't support nested group yet!

Route::group(['middleware'=>'web,api'],function(){
    Route::get('/',HomeController::class,'index');

    //Auth
    Route::get('auth/registration',AuthController::class,'registration');
    Route::post('auth/registration',AuthController::class,'registration');
});

