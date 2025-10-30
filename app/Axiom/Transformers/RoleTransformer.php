<?php

namespace App\Axiom\Transformers;

use Axiom\Http\Transformer;

class RoleTransformer  extends Transformer
{
    
    public function resource() :array
    {

        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'slug'=>$this->slug,
        ];
    }

    public function resources() :array
    {
        return [];
    }
}