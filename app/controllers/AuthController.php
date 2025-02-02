<?php

namespace App\controllers;

use App\models\User;
use App\serialize\UserSerializers;
use App\views\render\LandingView;
use Core\Validator;
use Exception;
use Facade\Auth;
use Facade\Hash;
use Facade\Response;
use Facade\Route;

class AuthController
{
    public function login($request){
        LandingView::init()->render('landings.login');
    }

    public function authenticate($request){
        $validator = new Validator($request,[
            'email'=>'required',
            'password'=>'required'
        ]);

        if(!$validator->validate()){
            $validator->setToResponse();
           Response::redirect('/auth/login')->send();
        }

        if($user = User::findByEmail($request->getBody('email'))){

        }
    }

    public function registration($request){
        LandingView::init()->render('landings.registration');
    }

    public function store($request){

        //validate data
        $validator = new Validator($request,[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'phone'=>'required',
            'avatar'=>'required|mimes:jpeg',
            'password'=>'required|match:password_confirmation|min:8|max:50'
        ]);

        if(!$validator->validate()){
            $validator->setToResponse();

            Response::json([
                'status'=>false,
                'message'=>"Registration Failed",
                'data'=>null
            ],500)->send();
        }

        //store
        $user = User::create([
            'name'=>$request->getBody('name'),
            'email'=>$request->getBody('email'),
            'phone'=>$request->getBody('phone'),
            'password'=>Hash::make($request->getBody('password')),
            'avatar'=>$request->file('avatar')->save(null,'/profile')
        ]);

        //login
        Auth::login($user);
        session()->regenerateId();

        Response::json([
        'status'=>true,
        'message'=>"Registration successful",
        'data'=>(new UserSerializers($user))->toArray()
       ])->send();
    }


    public function logOut($request){
        Auth::logout();
        session()->regenerateId();
    }
    

}