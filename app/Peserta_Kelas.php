<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peserta_Kelas extends Model
{
    protected $table = 'peserta_kelas';
    protected $primaryKey = 'id_peserta_kelas';
    public $timestamps = false;
    public function murid(){
        return $this->belongsTo('App\Murid', 'username', 'username');
    }
    public function kelas(){
        return $this->belongsTo('App\Kelas', 'id_kelas', 'id_kelas');
    }
    public function pendaftaran(){
        return $this->belongsTo('App\Pendaftaran', 'id_pendaftaran', 'id_pendaftaran');
    }
    public function kehadiran_peserta(){
        return $this->hasMany('App\kehadiran_peserta', 'id_peserta', 'id_peserta');
    }
}
