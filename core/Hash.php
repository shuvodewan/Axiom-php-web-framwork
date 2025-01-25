<?php

namespace Core;

class Hash
{
    public function make($value, $cost = null)
    {
        $options = [
            'cost' => $cost??config('app.hash_cost')
        ];
        return password_hash($value, PASSWORD_BCRYPT, $options);
    }
    public function check($value, $hash)
    {
        return password_verify($value, $hash);
    }
    public function rehash($hash)
    {
        return password_needs_rehash($hash, PASSWORD_BCRYPT, ['cost' => config('app.hash_cost')]);
    }
}