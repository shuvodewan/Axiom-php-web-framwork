<?php

namespace App\Axiom\Transformers;

use Axiom\Http\Transformer;

class TestTransformer  extends Transformer
{
    
    public function resource() :array
    {

        return [
            'name'=>$this->name,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'avatar'=>$this->avatar,
            'roles'=>(new RoleTransformer($this->roles))->getResource()->value(),
        ];
    }

    public function resources() :array
    {
        return [];
    }
}