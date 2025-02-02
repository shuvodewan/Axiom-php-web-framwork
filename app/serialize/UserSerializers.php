<?php

namespace App\serialize;

use Core\Serializer;

class UserSerializers extends Serializer
{
    protected function serialize($item):array
    {
        return [
            'name'=>$item->name,
            'email'=>$item->email,
            'phone'=>$item->phone,
        ];
    }
}