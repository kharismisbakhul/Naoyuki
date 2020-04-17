<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sesi_Jam extends Model
{
    protected $table = 'sesi_jam';
    protected $primaryKey = 'id_sesi';
    public $timestamps = false;
    public function jadwal_kosong(){
        return $this->hasMany('App\Jadwal_Kosong', 'id_sesi', 'id_sesi');
    }
    public function jadwal_kelas(){
        return $this->hasMany('App\Jadwal_Kelas', 'id_sesi', 'id_sesi');
    }
}
