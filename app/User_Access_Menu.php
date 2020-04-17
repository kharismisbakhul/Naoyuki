<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Access_Menu extends Model
{
    protected $table = 'user_access_menu';
    protected $primaryKey = 'id_access';
    public $timestamps = false;
}
