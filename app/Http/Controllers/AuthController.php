<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (session()->has('username')) {
            if (session('status_user') == 1) {
                return redirect('/murid');
            } else if (session('status_user') == 2) {
                return redirect('/sensei');
            } else if (session('status_user') == 3) {
                return redirect('/akademik');
            } else if (session('status_user') == 4) {
                return redirect('/marketing');
            } else {
                return redirect('/admin');
            }
        }
        return view('login');
    }
    public function landing()
    {
        return view('landing');
    }
    public function auth(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username tidak boleh kosong',
            'password.required'  => 'Password tidak boleh kosong'
        ]);

        $status = Auth::where(['username' => $request->username, 'password' => $request->password])
            ->join('status_user', 'user.id_status_user', '=', 'status_user.id_status_user')
            ->get()->first();

        if ($status != []) {
            $data = $status->toArray();
            session(['username' => $data['username'], 'status_user' => $data['id_status_user'], 'nama_status_user' => $data['nama_status_user'], 'image_profil' => $data['image']]);
            if (session('status_user') == 1) {
                $data_murid = DB::table('murid')->where(['username' => session('username')])->get()->first();
                session(['nama_lengkap' => $data_murid->nama_lengkap]);
                return redirect('/murid');
            } else if (session('status_user') == 2) {
                $data_murid = DB::table('sensei')->where(['username' => session('username')])->get()->first();
                session(['nama_lengkap' => $data_murid->nama_sensei]);
                return redirect('/sensei');
            } else if (session('status_user') == 3) {
                return redirect('/akademik');
            } else if (session('status_user') == 4) {
                return redirect('/marketing');
            } else {
                return redirect('/admin');
            }
        } else {
            return redirect('/')->with('statusEror', 'Login Gagal');
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/')->with('statusLogout', 'Logout Sukses');
    }

    public function profil()
    {
        if (session()->has('username')) {
            if (session('status_user') == 1) {
                return redirect('/murid/profil');
            } else if (session('status_user') == 2) {
                return redirect('/sensei/profil');
            } else if (session('status_user') == 3) {
                return redirect('/akademik/profil');
            } else if (session('status_user') == 4) {
                return redirect('/marketing/profil');
            } else {
                return redirect('/admin/profil');
            }
        }
    }

    public function getProgramLes($id)
    {
        Auth::getProgramLes($id);
    }
}
