<?php

namespace Core\support;

use App\models\User;

class Auth
{
    protected static $model = User::class;

    public function login($user){
        session()->set('auth_id',$user->id);
        return $user;
    }

    public function logout(){
        session()->set('auth_id',null);
    }

    public function id(){
        return session()->get('auth_id');
    }

    public function check($user){
        $auth_id = session()->get('auth_id');
        return $user->id==$auth_id;
    }

    public function user(){
        if($id = session()->get('auth_id')){
            return Auth::$model::find($id);
        }
    }
}