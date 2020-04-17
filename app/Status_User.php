<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status_User extends Model
{
    protected $table = 'status_user';
    protected $primaryKey = 'id_status_user';
    public $timestamps = false;

    public function user(){
        return $this->hasMany('App\User', 'id_status_user', 'id_status_user');
    }

    public function user_menu()
    {
        return $this->belongsToMany('App\User_Menu', 'user_access_menu', 'id_status_user', 'id_menu');
    }
}
