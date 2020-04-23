<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Murid extends Model
{
    protected $table = 'murid';
    protected $primaryKey = 'username';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['username', 'nama_lengkap', 'email', 'no_hp', 'asal_sekolah', 'alamat'];

    public function user()
    {
        return $this->belongsTo('App\User', 'username', 'username');
    }
    public function peserta_kelas(){
        return $this->hasMany('App\Peserta_Kelas', 'username', 'username');
    }
    public function pendaftaran(){
        return $this->hasMany('App\Pendaftaran', 'username', 'username');
    }

}
