<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auth extends Model
{
    protected $table = 'user';
    protected $fillable = ['username', 'password'];

    public static function getProgramLes($id)
    {
        $program_les = DB::table('program_les')->where(['id_program_les' => intval($id)])->get()->first();
        Header('Content-type: appliaction/json');
        echo json_encode($program_les);
    }
}
