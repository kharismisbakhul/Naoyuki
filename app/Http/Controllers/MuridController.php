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
        $data['kelas_berjalan'] = DB::table('pendaftaran')->where(['username' => session('username')])
            ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
            ->join('kelas', 'pendaftaran.id_program_les', '=', 'kelas.id_program_les')
            ->where('pendaftaran.status_pendaftaran', 1)
            ->get();

            // Header('Content-type: application/json');
            // echo json_encode($data['kelas_berjalan']);die;
        return view('murid.dashboard', $data);
    }

    public function jadwalLes()
    {
        $data['title'] = "Jadwal Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        return view('murid.jadwal_les', $data);
    }

    public function jadwalKosong()
    {
        $data['title'] = "Jadwal Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        return view('murid.jadwal_kosong', $data);
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

    public function getProgramTerdaftar($id)
    {
        Murid::getProgramTerdaftar($id);
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
        $status = Murid::daftar($request->program);
        if ($status == true) {
            return redirect('/murid/pembayaran/' . $status['id_pendaftaran'])->with('status', 'Pendaftaran berhasil, silahkan melakukan pembayaran');
        } else {
            return redirect('/murid/programLes')->with('status', 'Pendaftaran gagal');
        }
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
        // echo json_encode($id);
        // die;
        $file = $request->file('buktiDaftar');

        // echo $file->getClientOriginalName() . '<br>';
        // echo $file->getClientOriginalExtension() . '<br>';
        // echo $file->getSize() . '<br>';
        // echo $file->getMimeType() . '<br>';

        $tujuan_upload = public_path('bukti_pembayaran/');
        $file->move($tujuan_upload, $file->getClientOriginalName());
        $nama_file = $file->getClientOriginalName();

        Murid::bayar($id, $nama_file);
        return redirect('/murid/programLes')->with('status', 'Pembayaran berhasil dilakukan, silahkan menunggu konfirmasi sekitar 1 hari (Waktu Kerja)');
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
        $jumlah_pertemuan = DB::table('pertemuan')->select('id_kelas', DB::raw('count(id_pertemuan) as jumlah_pertemuan'))
        ->where('id_kelas', 1)
        ->groupBy('id_kelas')->get();

        $data['kelas_berjalan'] = DB::table('pendaftaran')->where(['username' => session('username')])
        ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
        ->join('kelas', 'pendaftaran.id_program_les', '=', 'kelas.id_program_les')
        ->where('pendaftaran.status_pendaftaran', 1)
        ->get();

        // Header('Content-type: application/json');
        // echo json_encode($data['kelas_berjalan']);die;
        
        return view('murid.pembelajaran', $data);
    }

    public function detailPembelajaran($id)
    {
        $data['title'] = "Pembelajaran";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        return view('murid.detail_pembelajaran', $data);
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
