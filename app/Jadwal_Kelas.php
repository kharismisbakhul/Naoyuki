<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal_Kelas extends Model
{
    protected $table = 'jadwal_kelas';
    protected $primaryKey = 'id_jadwal_kelas';
    public $timestamps = false;
    public function sesi(){
        return $this->belongsTo('App\Sesi_Jam', 'id_sesi', 'id_sesi');
    }
    public function hari(){
        return $this->belongsTo('App\Hari', 'id_hari', 'id_hari');
    }
    public function kelas(){
        return $this->belongsTo('App\Kelas', 'id_kelas', 'id_kelas');
    }
}
