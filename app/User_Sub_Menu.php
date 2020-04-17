<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Sub_Menu extends Model
{
    protected $table = 'user_sub_menu';
    protected $primaryKey = 'id_sub_menu';
    public $timestamps = false;

    public function menu(){
        return $this->belongsTo('App\User_Menu', 'id_menu', 'id_menu');
    }
}
