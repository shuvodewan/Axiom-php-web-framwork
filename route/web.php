<?php

use App\controllers\AuthController;
use App\controllers\LandingController;
use Core\facade\Route;


// Route::group(['middlewares'=>'test','prefix'=>'group','name'=>'group'],function(){
//     Route::middlewares('web')->prefix('test')->name('home')->get('home',LandingController::class,'index');

//     Route::group(['middlewares'=>'child','prefix'=>'child','name'=>'child'],function(){
//         Route::middlewares('childMiddle')->prefix('cprefix')->name('cname')->get('store',LandingController::class,'store');
//     });
// });

//  Route::get('update',LandingController::class,'update');

Route::group(['middleware'=>'web'],function(){
    Route::get('test',function($request){
        dd($request);
    });
    Route::get('/',LandingController::class,'index');
    Route::get('home',LandingController::class,'index');
    //Auth
    Route::get('auth/login',AuthController::class,'login','guest');
    Route::post('auth/login',AuthController::class,'authenticate','guest');
    Route::get('auth/registration',AuthController::class,'registration','guest');
    Route::post('auth/registration',AuthController::class,'store');
    Route::post('auth/logout',AuthController::class,'logout');


    //users
    Route::get('profile',LandingController::class,'profile','auth');
});

