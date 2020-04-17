<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kehadiran_Peserta extends Model
{
    protected $table = 'kehadiran_peserta';
    protected $primaryKey = 'id_kehadiran';
    public $timestamps = false;
    public function peserta(){
        return $this->belongsTo('App\Peserta_Kelas', 'id_peserta', 'id_peserta');
    }
    public function pertemuan(){
        return $this->belongsTo('App\Pertemuan', 'id_pertemuan', 'id_pertemuan');
    }
}
