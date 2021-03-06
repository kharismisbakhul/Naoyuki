<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    function tanggal($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
    }
    public function index()
    {
        $data['title'] = "Dashboard";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['jumlah_murid'] = \App\User::where(['id_status_user' => 1])->get()->count();
        $data['jumlah_sensei'] = \App\User::where(['id_status_user' => 2])->get()->count();
        
        return view('admin.dashboard', $data);
    }

    public function manajemenUser()
    {
        $data['title'] = "Manajemen User";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['user'] = \App\User::where('username', '!=', session('username'))
        ->join('status_user', 'user.id_status_user', '=', 'status_user.id_status_user')
        ->orderBy('user.id_status_user', 'asc')
        ->get();
        
        return view('admin.manajemen_user', $data);
    }

    public function viewTambahUser()
    {
        $data['title'] = "Manajemen User";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['status_user'] = \App\Status_User::all();
        
        return view('admin.tambah_user', $data);
    }

    public function tambahUser(Request $request)
    {   
        if($request->status == ''){
            $request->status = null;
        }

        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'status' => 'required'
        ], [
            'username.required' => 'Username tidak boleh kosong',
            'password.required'  => 'Password tidak boleh kosong',
            'status.required'  => 'Status User tidak boleh kosong'
        ]);

        $temp = \App\User::where('username', $request->username)->get();

        if($temp->isEmpty()){
            if($request->status == 1){
                $file = $request->file('fotoUser');
                
                $tujuan_upload = public_path('image/profil/');
        
                // echo json_encode($file);die;
                $file->move($tujuan_upload, $file->getClientOriginalName());
                $nama_file = 'image/profil/'.$file->getClientOriginalName();
    
                \App\User::insert([
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'id_status_user' => $request->status,
                    'image' => $nama_file
                ]);
    
                \App\Murid::insert([
                    'username' => $request->username,
                    'nama_lengkap' => $request->nama_lengkap_user,
                    'email' => $request->email_user,
                    'no_hp' => $request->no_hp_user,
                    'asal_sekolah' => $request->asal_sekolah_user,
                    'alamat' => $request->$request->alamat_user
                ]);
            }
            else if($request->status == 2){
    
                \App\User::insert([
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'id_status_user' => $request->status
                ]);
    
                \App\Sensei::insert([
                    'username' => $request->username,
                    'nama_sensei' => $request->nama_lengkap_user,
                    'no_hp' => $request->no_hp_user
                ]);
            }
            else{
                \App\User::insert([
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'id_status_user' => $request->status
                ]);
    
            }
            
            return redirect('/admin/manajemenUser')->with('status', 'Penambahan user berhasil');
        }
        else{
            return redirect('/admin/manajemenUser')->with('gagal', 'Username telah terdaftar');
        }

    }

    public function editUser(Request $request)
    {
        if($request->password == null){
            return redirect('/admin/manajemenUser')->with('gagal', 'Password tidak boleh kosong');
        }
        else{
            \App\User::where('id_user', $request->id_user)
            ->update([
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);
    
           return redirect('/admin/manajemenUser')->with('status', 'Perubahan data user berhasil');
        }
    }

    public function hapusUser($id)
    {
        
        $data = \App\User::find($id)->get()->first();

        if($data->id_status_user == 1){
            \App\Murid::where('username', $data->username)->delete();
            \App\Murid::where('username', $data->username)->delete();
        }elseif($data->id_status_user == 2){
            \App\Sensei::where('username', $data->username)->delete();
        }
        
        \App\User::find($id)->delete();
        return redirect('/admin/manajemenUser')->with('status', 'Penghapusan user berhasil');
    }

    public function getUser($id){
        $data = \App\User::where(['id_user' => $id])
        ->get()->first();

        Header('Content-type: application/json');
        echo json_encode($data);
    }
}
