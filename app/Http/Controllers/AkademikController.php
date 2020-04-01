<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Akademik;

class AkademikController extends Controller
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
        $data['program_les'] = DB::table('program_les')->get()->count();
        $data['kelas'] = DB::table('kelas')->get()->count();
        return view('akademik.dashboard', $data);
    }

    public function programLes()
    {
        $data['title'] = "Program Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['program_les'] = DB::table('program_les')->get();

        return view('akademik.program_les', $data);
    }
    public function detailProgramLes($id)
    {
        $data['title'] = "Program Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['program_les'] = DB::table('program_les')->where(['id_program_les' => intval($id)])->get()->first();
        $data['kelas'] = DB::table('kelas')->where(['pendaftaran.id_program_les' => intval($id)])
            ->join('peserta_kelas', 'kelas.id_kelas', '=', 'peserta_kelas.id_kelas')    
            ->join('pendaftaran', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
            ->join('sensei', 'kelas.id_sensei', '=', 'sensei.id_sensei')
            ->where('pendaftaran.status_pendaftaran', 1)
            ->get();
        return view('akademik.detail_program_les', $data);
    }

    public function tambahProgram()
    {
        $data['title'] = "Program Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['program_les'] = DB::table('program_les')->get();
        return view('akademik.tambah_program_les', $data);
    }
    public function tambahProgramLes(Request $request)
    {
        $file = $request->file('fotoProgram');
        
        $tujuan_upload = public_path('foto_program/');

        // echo json_encode($file);die;
        $file->move($tujuan_upload, $file->getClientOriginalName());
        $nama_file = 'foto_program/'.$file->getClientOriginalName();

        $status = Akademik::tambahProgram($request, $nama_file);
        if ($status == true) {
            return redirect('/akademik/programLes')->with('status', 'Penambahan Program berhasil');
        } else {
            return redirect('/akademik/programLes')->with('status', 'Penambahan Program gagal');
        }
    }

    public function tambahKelas($id)
    {
        $data['title'] = "Program Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['program_les'] = DB::table('program_les')->where(['id_program_les' => $id])->get();
        $data['murid'] = DB::table('murid')->get();
        $data['sensei'] = DB::table('sensei')->get();
        $data['sesi'] = DB::table('sesi_jam')->get();
        $data['hari'] = DB::table('hari')->get();
        return view('akademik.tambah_kelas', $data);
    }
    public function tambahKelasLes(Request $request)
    {
        $status = Akademik::tambahKelas($request);
        if ($status == true) {
            return redirect('/akademik/programLes')->with('status', 'Penambahan Kelas Berhasil');
        } else {
            return redirect('/akademik/programLes')->with('status', 'Penambahan Kelas Gagal');
        }
    }
}