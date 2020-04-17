<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    protected $table = 'pertemuan';
    protected $primaryKey = 'id_pertemuan';
    public $timestamps = false;
    public function kelas(){
        return $this->belongsTo('App\Kelas', 'id_kelas', 'id_kelas');
    }
    public function kehadiran_peserta(){
        return $this->hasMany('App\kehadiran_peserta', 'id_pertemuan', 'id_pertemuan');
    }
    
}
