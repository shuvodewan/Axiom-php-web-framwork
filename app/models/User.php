<?php

namespace App\models;

use Core\application\Model;

class User extends Model
{
    static function setTable()
    {
        static::$table = 'users';
    }

    public static function findByEmail($email, $raw=false)
    {
        self::boot();
        $stmt = static::$pdo->prepare("SELECT * FROM " . static::getTable() . " WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        if($row = $stmt->fetch()){
            return $raw?$row:self::hydrate($row);
        }
    }
}