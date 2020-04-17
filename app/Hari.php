<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hari extends Model
{
    protected $table = 'hari';
    protected $primaryKey = 'id_hari';
    public $timestamps = false;
    public function jadwal_kosong(){
        return $this->hasMany('App\Jadwal_Kosong', 'id_hari', 'id_hari');
    }
    public function jadwal_kelas(){
        return $this->hasMany('App\Jadwal_Kelas', 'id_hari', 'id_hari');
    }
}
