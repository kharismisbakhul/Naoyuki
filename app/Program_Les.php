<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program_Les extends Model
{
    protected $table = 'program_les';
    protected $primaryKey = 'id_program_les';
    public $timestamps = false;

    public function pendaftaran(){
        return $this->hasMany('App\Pendaftaran', 'id_program_les', 'id_program_les');
    }
    
}
