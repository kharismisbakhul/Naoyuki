<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal_Kosong extends Model
{
    protected $table = 'jadwal_kosong';
    protected $primaryKey = 'id_jadwal_kosong';
    public $timestamps = false;
    public function sesi(){
        return $this->belongsTo('App\Sesi_Jam', 'id_sesi', 'id_sesi');
    }
    public function hari(){
        return $this->belongsTo('App\Hari', 'id_hari', 'id_hari');
    }
    public function user(){
        return $this->belongsTo('App\User', 'username', 'username');
    }
}
