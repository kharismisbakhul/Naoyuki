<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    public $timestamps = false;

    public function sensei(){
        return $this->belongsTo('App\Sensei', 'id_sensei', 'id_sensei');
    }
    public function peserta_kelas(){
        return $this->hasMany('App\Peserta_Kelas', 'id_kelas', 'id_kelas');
    }
    public function pertemuan(){
        return $this->hasMany('App\Pertemuan', 'id_kelas', 'id_kelas');
    }
}
