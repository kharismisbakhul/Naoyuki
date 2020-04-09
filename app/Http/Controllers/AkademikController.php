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
            ->join('program_les', 'program_les.id_program_les', '=', 'pendaftaran.id_program_les')
            ->join('sensei', 'kelas.id_sensei', '=', 'sensei.id_sensei')
            ->where('pendaftaran.status_pendaftaran', 1)
            ->get();


            for ($i=0; $i < count($data['kelas']) ; $i++) { 
                $data['kelas'][$i]->jadwal = DB::table('jadwal_kelas')
                ->join('hari', 'hari.id_hari', '=', 'jadwal_kelas.id_hari')
                ->join('sesi_jam', 'sesi_jam.id_sesi', '=', 'jadwal_kelas.id_sesi')
                ->where('id_kelas', "=", $data['kelas'][$i]->id_kelas)
                ->get();;

                $data['kelas'][$i]->pertemuan = DB::table('pertemuan')
                ->where('id_kelas', "=", $data['kelas'][$i]->id_kelas)
                ->get()->count();
            }

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
        $data['program_les'] = DB::table('program_les')->where(['id_program_les' => $id])->get()->first();
        $data['murid'] = DB::table('pendaftaran')
        ->join('murid', 'pendaftaran.username', '=', 'murid.username')
        ->where('pendaftaran.status_pendaftaran', 3)
        ->where('pendaftaran.id_program_les', $id)
        ->get();
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

    public function editMateri(Request $request){
        DB::update('update program_les set cakupan_materi = ? where id_program_les = ?', [$request->materi, intval($request->id_program_les)]);
        return redirect('/akademik/detailProgramLes/'.$request->id_program_les)->with('status', 'Materi berhasil diupdate');
    }

    public function getDetailKelas($id){
        $data = DB::table('kelas')->where(['id_kelas' => $id])
        ->get()->first();

        $data->peserta = DB::table('peserta_kelas')->where(['id_kelas' => $id])
        ->join('murid', 'peserta_kelas.username', '=', 'murid.username')
        ->get();

        $data->pertemuan = DB::table('pertemuan')->where(['id_kelas' => $id])
        ->get();

        for ($i=0; $i < count($data->pertemuan) ; $i++) { 
            $data->pertemuan[$i]->tanggal_indo = $this->tanggal($data->pertemuan[$i]->tanggal);
        }

        Header('Content-type: application/json');
        echo json_encode($data);
    }
}