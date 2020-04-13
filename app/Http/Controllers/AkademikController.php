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
        $data['jadwal_kosong'] = DB::table('jadwal_kosong')
        // ->where(['username' => 'Kharis'])
        ->join('sesi_jam', 'jadwal_kosong.id_sesi', '=', 'sesi_jam.id_sesi')
        ->join('hari', 'jadwal_kosong.id_hari', '=', 'hari.id_hari')
        ->groupBy('jadwal_kosong.id_sesi')
        ->groupBy('jadwal_kosong.id_hari')
        ->get();

        // Header('Content-type: application/json');
        // echo json_encode($data['jadwal_kosong']);
        // die;
        
        $data['sensei'] = DB::table('sensei')->get();


        $data['sesi'] = DB::table('sesi_jam')->get();
        $data['hari'] = DB::table('hari')->get();
        return view('akademik.tambah_kelas', $data);
    }
    
    function getRandomColor() 
    {
        $letters = '0123456789ABCDEF';
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
            $color = $color.''.$letters[random_int(0,15)];
        }
        return $color;
    }

    public function tambahKelasLes(Request $request)
    {
        
        $status = Akademik::tambahKelas($request, $this->getRandomColor());
        if ($status == true) {
            return redirect('/akademik/detailProgramLes/'.$request->nama_program)->with('status', 'Penambahan Kelas Berhasil');
        } else {
            return redirect('/akademik/detailProgramLes/'.$request->nama_program)->with('status', 'Penambahan Kelas Gagal');
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
            $data->pertemuan[$i]->kehadiran_peserta = DB::table('kehadiran_peserta')
            ->where(['id_pertemuan' => $data->pertemuan[$i]->id_pertemuan])
            ->join('peserta_kelas', 'kehadiran_peserta.id_peserta', '=', 'peserta_kelas.id_peserta_kelas')
            ->join('murid', 'peserta_kelas.username', '=', 'murid.username')
            ->get();
        }

        Header('Content-type: application/json');
        echo json_encode($data);
    }

    public function getMurid($id){
        $data = DB::table('pendaftaran')
        ->join('murid', 'pendaftaran.username', '=', 'murid.username')
        ->where('pendaftaran.status_pendaftaran', 3)
        ->where('pendaftaran.id_program_les', $id)
        ->get();

        Header('Content-type: application/json');
        echo json_encode($data);
    }

    public function getJadwalKosong(Request $request){
        $murid = [];
        if($request->get('murid1')){
            array_push($murid, intval($request->get('murid1')));
        }
        if($request->get('murid2')){
            array_push($murid, intval($request->get('murid2')));
        }
        
        $pendaftar = DB::table('pendaftaran')
        // ->join('murid', 'pendaftaran.username', '=', 'murid.username')
        ->whereIn('id_pendaftaran', $murid)
        ->get();
        
        $username_murid = [];
        for ($i=0; $i < count($pendaftar); $i++) { 
            array_push($username_murid, $pendaftar[$i]->username);
        }
        
        
        
        $data1 = DB::table('jadwal_kosong')
        // ->join('sesi_jam', 'jadwal_kosong.id_sesi', '=', 'sesi_jam.id_sesi')
        ->join('hari', 'jadwal_kosong.id_hari', '=', 'hari.id_hari')
        ->where('status_kosong', 0)
        ->where('username', $username_murid[0])
        // ->groupBy('jadwal_kosong.id_sesi')
        // ->groupBy('jadwal_kosong.id_hari')
        ->get();

        $jadwal_kosong = [];

        // 2 Murid
        if(count($username_murid) == 2){
            $data2 = DB::table('jadwal_kosong')
            ->join('hari', 'jadwal_kosong.id_hari', '=', 'hari.id_hari')
            ->where('status_kosong', 0)
            ->where('username', $username_murid[1])
            ->get();

            for ($i=0; $i < count($data1); $i++) { 
                for ($j=0; $j < count($data2); $j++) { 
                    if($data1[$i]->id_sesi == $data2[$j]->id_sesi && $data1[$i]->id_hari == $data2[$j]->id_hari){
                         array_push($jadwal_kosong, $data1[$i]);
                    }
                    # code...
                }
            }
        }
        else{
            $jadwal_kosong = $data1;
        }

        Header('Content-type: application/json');
        echo json_encode($jadwal_kosong);
        // die;
    }
    public function getSesi(Request $request){
        $id_hari = intval($request->get('id_hari'));
        $murid = intval($request->get('murid'));
        
        $pendaftar = DB::table('pendaftaran')
        // ->join('murid', 'pendaftaran.username', '=', 'murid.username')
        ->where('id_pendaftaran', $murid)
        ->get()->first();
        
        
        $data = DB::table('jadwal_kosong')
        ->join('sesi_jam', 'jadwal_kosong.id_sesi', '=', 'sesi_jam.id_sesi')
        // ->join('hari', 'jadwal_kosong.id_hari', '=', 'hari.id_hari')
        ->where('status_kosong', 0)
        ->where('username', $pendaftar->username)
        ->where('id_hari', $id_hari)
        // ->groupBy('jadwal_kosong.id_sesi')
        // ->groupBy('jadwal_kosong.id_hari')
        ->get();

        Header('Content-type: application/json');
        echo json_encode($data);
        // die;
    }

    public function getSensei(Request $request){
        $id_hari1 = intval($request->get('id_hari1'));
        $id_sesi1 = intval($request->get('id_sesi1'));
        $id_hari2 = intval($request->get('id_hari2'));
        $id_sesi2 = intval($request->get('id_sesi2'));

        $hari = [];
        $sesi = [];

        // array_push($hari, $id_hari1);
        // array_push($sesi, $id_sesi1);
        // array_push($hari, $id_hari2);
        // array_push($sesi, $id_sesi2);
        
        // Tabel 1
        $data1 = DB::table('jadwal_kosong')
        ->join('user', 'jadwal_kosong.username', '=', 'user.username')
        // ->join('sesi_jam', 'jadwal_kosong.id_sesi', '=', 'sesi_jam.id_sesi')
        // ->join('hari', 'jadwal_kosong.id_hari', '=', 'hari.id_hari')
        ->where('status_kosong', 0)
        ->where('id_status_user', 2)
        ->where('id_hari', $id_hari1)
        ->where('id_sesi', $id_sesi1)
        // ->where('username', $pendaftar->username)
        // ->whereIn('id_hari', $hari)
        // ->whereIn('id_sesi', $sesi)
        // ->groupBy('jadwal_kosong.id_sesi')
        // ->groupBy('jadwal_kosong.id_hari')
        ->get();

        $data2 = DB::table('jadwal_kosong')
        ->join('user', 'jadwal_kosong.username', '=', 'user.username')
        // ->join('sesi_jam', 'jadwal_kosong.id_sesi', '=', 'sesi_jam.id_sesi')
        // ->join('hari', 'jadwal_kosong.id_hari', '=', 'hari.id_hari')
        ->where('status_kosong', 0)
        ->where('id_status_user', 2)
        ->where('id_hari', $id_hari2)
        ->where('id_sesi', $id_sesi2)
        // ->where('username', $pendaftar->username)
        // ->whereIn('id_hari', $hari)
        // ->whereIn('id_sesi', $sesi)
        // ->groupBy('jadwal_kosong.id_sesi')
        // ->groupBy('jadwal_kosong.id_hari')
        ->get();

        $username_sensei = [];

        for ($i=0; $i < count($data1); $i++) { 
            for ($j=0; $j < count($data2); $j++) { 
                if($data1[$i]->username == $data2[$j]->username){
                     array_push($username_sensei, $data1[$i]->username);
                }
                # code...
            }
        }

        $sensei = DB::table('sensei')
        ->whereIn('username', $username_sensei)
        ->get();


        Header('Content-type: application/json');
        echo json_encode($sensei);
        // die;
    }

}