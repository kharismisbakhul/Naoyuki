<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    protected $table = 'user';
    protected $fillable = ['username', 'password'];

    public static function hello()
    {
        echo "HAHAHAHAHA";
    }
}
