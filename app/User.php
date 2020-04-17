<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $fillable = ['username', 'password', 'image'];

    public function status_user(){
        return $this->belongsTo('App\Status_User', 'id_status_user', 'id_status_user');
    }
    public function sensei(){
        return $this->hasOne('App\Murid', 'username', 'username');
    }
    public function murid(){
        return $this->hasOne('App\Murid', 'username', 'username');
    }
    public function jadwal_kosong(){
        return $this->hasMany('App\Jadwal_Kosong', 'username', 'username');
    }
}
