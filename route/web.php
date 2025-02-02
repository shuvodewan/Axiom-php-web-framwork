<?php

use App\controllers\AuthController;
use App\controllers\LandingController;
use Facade\Route;

//Route doesn't support nested group yet!

Route::group(['middleware'=>'web'],function(){
    Route::get('/',LandingController::class,'index');

    //Auth
    Route::get('auth/login',AuthController::class,'login','guest');
    Route::post('auth/login',AuthController::class,'authenticate','guest');
    Route::get('auth/registration',AuthController::class,'registration','guest');
    Route::post('auth/registration',AuthController::class,'store');
    Route::post('auth/logout',AuthController::class,'logout');


    //users
    Route::get('profile',LandingController::class,'profile','auth');
});

