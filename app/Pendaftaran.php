<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';
    protected $fillable = ['username', 'id_program_les', 'status_pendaftaran', 'bukti_pendaftaran', 'tanggal_mulai', 'tanggal_pendaftaran', 'waktu_pendaftaran'];    

    public function program_les(){
        return $this->belongsTo('App\Program_Les', 'id_program_les', 'id_program_les');
    }
    public function murid(){
        return $this->belongsTo('App\Murid', 'username', 'username');
    }
    public function peserta_kelas(){
        return $this->hasMany('App\Peserta_Kelas', 'id_pendaftaran', 'id_pendaftaran');
    }
}
