<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Menu extends Model
{
    protected $table = 'user_menu';
    protected $primaryKey = 'id_menu';
    public $timestamps = false;

    public function sub_menu(){
        return $this->hasMany('App\User_Sub_Menu', 'id_menu', 'id_menu');
    }
    public function status_user()
    {
        return $this->belongsToMany('App\Status_User', 'user_access_menu', 'id_menu', 'id_status_user');
    }
}
