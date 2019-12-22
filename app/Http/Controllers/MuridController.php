<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Murid;

class MuridController extends Controller
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
        $data['program_berjalan'] = DB::table('pendaftaran')->where(['username' => session('username')])
            ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
            ->get();
        return view('murid.dashboard', $data);
    }

    public function jadwalLes()
    {
        $data['title'] = "Jadwal Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        return view('murid.jadwal_les', $data);
    }

    public function programLes()
    {
        $data['title'] = "Program Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['program_les'] = DB::table('program_les')->get();
        $data['program_berjalan'] = DB::table('pendaftaran')->where(['username' => session('username')])
            ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
            ->get();
        return view('murid.program_les', $data);
    }

    public function daftarProgram()
    {
        $data['title'] = "Program Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['program_les'] = DB::table('program_les')->get();
        return view('murid.daftar_program_les', $data);
    }

    public function daftar(Request $request)
    {

        // $request->validate([
        //     'nama' => 'required',
        //     'nrp' => 'required|size:5',
        // ], [
        //     'nama.required' => 'Nama tidak boleh kosong',
        //     'nrp.required'  => 'NRP tidak boleh kosong',
        //     'nrp.size' => 'NRP harus lebih dari 5'
        // ]);

        $status = Murid::daftar($request->program);
        return redirect('/murid/pembayaran/' . $status['id_pendaftaran'])->with('status', 'Pendaftaran berhasil, silahkan melakukan pembayaran');
    }

    public function pembayaran($id)
    {
        $data['title'] = "Program Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['program_les'] = DB::table('program_les')->get();
        $data['data_pendaftaran'] = DB::table('pendaftaran')->where(['id_pendaftaran' => $id])->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
            ->join('murid', 'pendaftaran.username', '=', 'murid.username')
            ->get()->first();
        $data['tanggal_pendaftaran'] = $this->tanggal($data['data_pendaftaran']->tanggal_pendaftaran);
        return view('murid.pembayaran', $data);
    }

    public function bayar(Request $request, $id)
    {
        // echo json_encode($_FILES['buktiDaftar']['name']);
        // die;
        $file = $request->file('buktiDaftar');

        echo $file->getClientOriginalName() . '<br>';
        echo $file->getClientOriginalExtension() . '<br>';
        echo $file->getSize() . '<br>';
        echo $file->getMimeType() . '<br>';

        $tujuan_upload = public_path('bukti_pembayaran/');
        $file->move($tujuan_upload, $file->getClientOriginalName());
        die;

        // DB::update('update murid set email = ?, no_hp = ? where username = ?', [$request->email, $request->no_telp, $request->username]);
        // if ($_FILES['buktiDaftar']['name']) {
        //     $dataUjian['bukti_ujian'] = $_FILES['buktiDaftar']['name'];
        //     $config['allowed_types'] = 'jpg|png|pdf';
        //     $config['max_size']     = '2048'; //kb
        //     $config['upload_path'] = './assets/ujian/';
        //     $config['file_name'] = time() . '_' . $data['user_login']['nim'] . '_' . $dataUjian['bukti_ujian'];
        //     $this->load->library('upload', $config);
        //     if ($this->upload->do_upload('buktiDaftar')) {
        //         $dataUjian['bukti_ujian'] = $this->upload->data('file_name');
        //     } else {
        //         $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Data ujian gagal di tambah ! </div>');
        //         echo $this->upload->display_errors();
        //     }
        // }
    }

    public function profil()
    {
        $data['title'] = "Profil";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['profil'] = Murid::where(['username' => session('username')])->get()->first();
        return view('murid.profil', $data);
    }

    public function pembelajaran()
    {
        $data['title'] = "Pembelajaran";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        return view('murid.pembelajaran', $data);
    }

    public function editProfil(Request $request)
    {
        //
        // $request->validate([
        //     'nama' => 'required',
        //     'nrp' => 'required|size:5',
        // ], [
        //     'nama.required' => 'Nama tidak boleh kosong',
        //     'nrp.required'  => 'NRP tidak boleh kosong',
        //     'nrp.size' => 'NRP harus lebih dari 5'
        // ]);

        // echo json_encode($request->email);
        // die;
        // Student::where('id', $student->id)
        //     ->update([
        //         'nama' => $request->nama,
        //         'nrp' => $request->nrp,
        //         'email' => $request->email,
        //         'jurusan' => $request->jurusan
        //     ]);
        if ($request->email == null || $request->no_telp == null) {
            return redirect('/murid/profil')->with('status', 'Eror');
        } else {
            Murid::editProfil($request);
            return redirect('/murid/profil')->with('status', 'Data berhasil diperbarui');
        }
    }
}
