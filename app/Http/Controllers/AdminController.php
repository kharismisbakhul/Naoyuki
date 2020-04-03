<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

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
        $data['jumlah_murid'] = DB::table('user')->where(['id_status_user' => 1])->get()->count();
        $data['jumlah_sensei'] = DB::table('user')->where(['id_status_user' => 2])->get()->count();
        
        return view('admin.dashboard', $data);
    }

    public function manajemenUser()
    {
        $data['title'] = "Manajemen User";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['user'] = DB::table('user')->where('username', '!=', session('username'))
        ->join('status_user', 'user.id_status_user', '=', 'status_user.id_status_user')
        ->get();
        
        return view('admin.manajemen_user', $data);
    }

    public function viewTambahUser()
    {
        $data['title'] = "Manajemen User";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['status_user'] = DB::table('status_user')
        ->get();
        
        return view('admin.tambah_user', $data);
    }

    public function tambahUser(Request $request)
    {
        DB::insert('insert into user (username, password, id_status_user) values (?, ?, ?)', [$request->username, $request->password, $request->status]);
        return redirect('/admin/manajemenUser')->with('status', 'Penambahan user berhasil');
    }

    public function editUser(Request $request)
    {
        DB::update('update user set username = ?, password = ? where id_user = ?', [$request->username, $request->password, $request->id_user]);
        return redirect('/admin/manajemenUser')->with('status', 'Perubahan data user berhasil');
    }

    public function hapusUser($id)
    {
        DB::table('user')->where('id_user', '=', $id)->delete();
        return redirect('/admin/manajemenUser')->with('status', 'Penghapusan user berhasil');
    }

    public function getUser($id){
        $data = DB::table('user')->where(['id_user' => $id])
        ->get()->first();

        Header('Content-type: application/json');
        echo json_encode($data);
    }
}
