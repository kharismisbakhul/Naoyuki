<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensei extends Model
{
    protected $table = 'sensei';
    protected $primaryKey = 'id_sensei';

    public function user()
    {
        return $this->belongsTo('App\User', 'username', 'username');
    }

    public function kelas(){
        return $this->hasMany('App\Kelas', 'id_sensei', 'id_sensei');
    }

}
