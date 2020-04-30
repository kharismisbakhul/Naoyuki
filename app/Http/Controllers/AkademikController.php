<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Akademik;
use Illuminate\Support\Facades\Input;

class AkademikController extends Controller
{
    function tanggal($tanggal)
    {
        $bulan = array(
            1 => 'Januari',
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

        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }

    public function notif()
    {
        $data['notif'] = \App\Pendaftaran::where('pendaftaran.status_pendaftaran', 3)
            ->join('murid', 'pendaftaran.username', '=', 'murid.username')
            ->join('program_les', 'program_les.id_program_les', '=', 'pendaftaran.id_program_les')
            ->orderBy('pendaftaran.tanggal_pendaftaran', 'asc')
            ->orderBy('pendaftaran.waktu_pendaftaran', 'asc')
            ->get();

        for ($i = 0; $i < count($data['notif']); $i++) {
            $data['notif'][$i]->tgl_indo = $this->tanggal($data['notif'][$i]->tanggal_pendaftaran);
        }

        $data['count_notif'] = count($data['notif']);
        return $data;
    }

    public function index()
    {
        $data['title'] = "Dashboard";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['program_les'] = \App\Program_Les::all()->count();
        $data['kelas'] = \App\Kelas::all()->count();
        $data['notifikasi'] = $this->notif();
        // Header('Content-type: application/json');
        // echo json_encode($data['notifikasi']);
        // die;

        return view('akademik.dashboard', $data);
    }

    public function programLes()
    {
        $data['title'] = "Program Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['program_les'] = \App\Program_Les::all();
        $data['notifikasi'] = $this->notif();

        return view('akademik.program_les', $data);
    }
    public function detailProgramLes($id)
    {
        $data['title'] = "Program Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['notifikasi'] = $this->notif();
        $data['program_les'] = \App\Program_Les::where(['id_program_les' => intval($id)])->get()->first();
        $data['kelas'] = \App\Kelas::where(['pendaftaran.id_program_les' => intval($id)])
            ->join('peserta_kelas', 'kelas.id_kelas', '=', 'peserta_kelas.id_kelas')
            ->join('pendaftaran', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
            ->join('program_les', 'program_les.id_program_les', '=', 'pendaftaran.id_program_les')
            ->join('sensei', 'kelas.id_sensei', '=', 'sensei.id_sensei')
            ->where('pendaftaran.status_pendaftaran', 1)
            ->get();


        for ($i = 0; $i < count($data['kelas']); $i++) {
            $data['kelas'][$i]->jadwal = \App\Jadwal_Kelas::join('hari', 'hari.id_hari', '=', 'jadwal_kelas.id_hari')
                ->join('sesi_jam', 'sesi_jam.id_sesi', '=', 'jadwal_kelas.id_sesi')
                ->where('id_kelas', "=", $data['kelas'][$i]->id_kelas)
                ->get();;

            $data['kelas'][$i]->pertemuan = \App\Pertemuan::where('id_kelas', "=", $data['kelas'][$i]->id_kelas)
                ->get()->count();
        }

        return view('akademik.detail_program_les', $data);
    }

    public function tambahProgram()
    {
        $data['title'] = "Program Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['notifikasi'] = $this->notif();
        $data['program_les'] = \App\Program_Les::all();
        return view('akademik.tambah_program_les', $data);
    }
    public function tambahProgramLes(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jumlah_pertemuan' => 'required',
            'biaya' => 'required',
            'materi' => 'required',
            'deskripsi' => 'required'
        ], [
            'nama.required' => 'Nama Program tidak boleh kosong',
            'jumlah_pertemuan.required' => 'Jumlah Pertemuan tidak boleh kosong',
            'biaya.required' => 'Biaya tidak boleh kosong',
            'materi.required' => 'Materi tidak boleh kosong',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong'
        ]);

        if ($request->file('fotoProgram') == null) {
            return redirect('/akademik/programLes')->with('gagal', 'Penambahan Program gagal, Foto Gambar tidak boleh Kosong');
        }
        else {
            $file = $request->file('fotoProgram');

            $tujuan_upload = public_path('foto_program/');
    
            // echo json_encode($file);die;
            $file->move($tujuan_upload, $file->getClientOriginalName());
            $nama_file = 'foto_program/' . $file->getClientOriginalName();
    
            // $status = Akademik::tambahProgram($request, $nama_file);
            \App\Program_Les::insert([
                'nama_program_les' => $request->nama,
                'image' => $nama_file,
                'jumlah_pertemuan' => $request->jumlah_pertemuan,
                'deskripsi' => $request->deskripsi,
                'cakupan_materi' => $request->materi,
                'biaya' => $request->biaya,
            ]);
            // DB::insert('insert into program_les (nama_program_les, image, jumlah_pertemuan, deskripsi, cakupan_materi, biaya) values (?, ?, ?, ?, ?, ?)', [$data->nama, $nama_file ,$data->jumlah_pertemuan, $data->deskripsi, $data->materi, $data->biaya]);
            return redirect('/akademik/programLes')->with('status', 'Penambahan Program berhasil');
        }
    }

    public function tambahKelas($id)
    {
        $data['title'] = "Program Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['notifikasi'] = $this->notif();
        $data['program_les'] = \App\Program_Les::where(['id_program_les' => $id])->get()->first();
        $data['murid'] = \App\Pendaftaran::join('murid', 'pendaftaran.username', '=', 'murid.username')
            ->where('pendaftaran.status_pendaftaran', 3)
            ->where('pendaftaran.id_program_les', $id)
            ->get();
        $data['jadwal_kosong'] = \App\Jadwal_Kosong::
            join('sesi_jam', 'jadwal_kosong.id_sesi', '=', 'sesi_jam.id_sesi')
            ->join('hari', 'jadwal_kosong.id_hari', '=', 'hari.id_hari')
            ->groupBy('jadwal_kosong.id_sesi')
            ->groupBy('jadwal_kosong.id_hari')
            ->get();

        return view('akademik.tambah_kelas', $data);
    }

    function getRandomColor()
    {
        $letters = '0123456789ABCDEF';
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
            $color = $color . '' . $letters[random_int(0, 15)];
        }
        return $color;
    }

    public function tambahKelasLes(Request $request)
    {
        if ($request->nama_murid == '' || $request->hariPertemuan1 == '' || $request->waktuPertemuan1 == '' || $request->hariPertemuan2 == '' || $request->waktuPertemuan2 == '' || $request->nama_sensei == '') {
            $request->nama_murid = null;
            $request->hariPertemuan1 = null;
            $request->waktuPertemuan1 = null;
            $request->hariPertemuan2 = null;
            $request->waktuPertemuan2 = null;
            $request->nama_sensei = null;
        }

        $request->validate([
            'nama_kelas' => 'required',
            'hariPertemuan1' => 'required',
            'waktuPertemuan1' => 'required',
            'hariPertemuan2' => 'required',
            'waktuPertemuan2' => 'required',
            'nama_sensei' => 'required'
        ], [
            'nama_kelas.required' => 'Nama Kelas tidak boleh kosong',
            'hariPertemuan1.required' => 'Hari Pertemuan 1 boleh kosong',
            'waktuPertemuan1.required' => 'Sesi Pertemuan 1 boleh kosong',
            'hariPertemuan2.required' => 'Hari Pertemuan 2 tidak boleh kosong',
            'waktuPertemuan2.required' => 'Sesi Pertemuan 2 tidak boleh kosong',
            'nama_sensei.required' => 'Sensei tidak boleh kosong'
        ]);

        $kelas = \App\Kelas::where('nama_kelas', $request->nama_kelas)->get();

        if($kelas->isEmpty()){
            \App\Kelas::insert([
                'nama_kelas' => $request->nama_kelas,
                'id_sensei' => $request->nama_sensei,
                'color' => $this->getRandomColor()
            ]);
    
            $dataA = \App\Kelas::where(['nama_kelas' => $request->nama_kelas, 'id_sensei' => $request->nama_sensei])
                ->get()->first();
    
            $sensei = \App\Sensei::where(['id_sensei' => $request->nama_sensei])
                ->get()->first();
    
            \App\Pendaftaran::whereIn('id_pendaftaran', $request->peserta)->update(['status_pendaftaran' => 1]);
    
            \App\Jadwal_Kosong::where('id_sesi', $request->waktuPertemuan1)
                ->where('id_hari', $request->hariPertemuan1)
                ->where('username', $sensei->username)
                ->update(array('status_kosong' => 1));
    
            \App\Jadwal_Kosong::where('id_sesi', $request->waktuPertemuan2)
                ->where('id_hari', $request->hariPertemuan2)
                ->where('username', $sensei->username)
                ->update(array('status_kosong' => 1));
    
            $dataB = \App\Pendaftaran::join('murid', 'pendaftaran.username', '=', 'murid.username')
                ->whereIn('pendaftaran.id_pendaftaran', $request->peserta)
                ->get();
    
            for ($i = 0; $i < count($dataB); $i++) {
    
                \App\Peserta_Kelas::insert([
                    'username' => $dataB[$i]->username,
                    'id_kelas' => $dataA->id_kelas,
                    'id_pendaftaran' => $dataB[$i]->id_pendaftaran,
                    'nilai_evaluasi' => 0,
                    'status_les' => 0
                ]);
    
                \App\Jadwal_Kosong::where('id_sesi', $request->waktuPertemuan1)
                    ->where('id_hari', $request->hariPertemuan1)
                    ->where('username', $dataB[$i]->username)
                    ->update(array('status_kosong' => 1));
    
                \App\Jadwal_Kosong::where('id_sesi', $request->waktuPertemuan2)
                    ->where('id_hari', $request->hariPertemuan2)
                    ->where('username', $dataB[$i]->username)
                    ->update(array('status_kosong' => 1));
            }
            
                    // Jadwal 1
            \App\Jadwal_Kelas::insert([
                'id_kelas' => $dataA->id_kelas,
                'id_hari' => $request->hariPertemuan1,
                'id_sesi' => $request->waktuPertemuan1
            ]);
    
                    // Jadwal 2
            \App\Jadwal_Kelas::insert([
                'id_kelas' => $dataA->id_kelas,
                'id_hari' => $request->hariPertemuan2,
                'id_sesi' => $request->waktuPertemuan2
            ]);
            return redirect('/akademik/detailProgramLes/' . $request->nama_program)->with('status', 'Penambahan Kelas Berhasil');
        }
        else{
            return redirect('/akademik/detailProgramLes/' . $request->nama_program)->with('gagal', 'Penambahan Kelas gagal, nama kelas sudah ada');
        }
    }

    public function editMateri(Request $request)
    {
        if($request->materi == null){
            return redirect('/akademik/detailProgramLes/' . $request->id_program_les)->with('gagal', 'Materi tidak boleh kosong');
        }
        else{
            \App\Program_Les::where('id_program_les', intval($request->id_program_les))
                ->update([
                'cakupan_materi' => $request->materi
            ]);
    
            return redirect('/akademik/detailProgramLes/' . $request->id_program_les)->with('status', 'Materi berhasil diupdate');
        }
    }

    public function getDetailKelas($id)
    {
        $data = \App\Kelas::where(['id_kelas' => $id])
            ->get()->first();

        $data->peserta = \App\Peserta_Kelas::where(['id_kelas' => $id])
            ->join('murid', 'peserta_kelas.username', '=', 'murid.username')
            ->get();

        $data->pertemuan = \App\Pertemuan::where(['id_kelas' => $id])
            ->get();

        for ($i = 0; $i < count($data->pertemuan); $i++) {
            $data->pertemuan[$i]->tanggal_indo = $this->tanggal($data->pertemuan[$i]->tanggal);
            $data->pertemuan[$i]->kehadiran_peserta = \App\Kehadiran_Peserta::where(['id_pertemuan' => $data->pertemuan[$i]->id_pertemuan])
                ->join('peserta_kelas', 'kehadiran_peserta.id_peserta', '=', 'peserta_kelas.id_peserta_kelas')
                ->join('murid', 'peserta_kelas.username', '=', 'murid.username')
                ->get();
        }

        Header('Content-type: application/json');
        echo json_encode($data);
    }

    public function getMurid($id)
    {
        $data = \App\Pendaftaran::join('murid', 'pendaftaran.username', '=', 'murid.username')
            ->where('pendaftaran.status_pendaftaran', 3)
            ->where('pendaftaran.id_program_les', $id)
            ->get();

        Header('Content-type: application/json');
        echo json_encode($data);
    }

    public function getJadwalKosong(Request $request)
    {
        $murid = $request->murid;

        $pendaftar = \App\Pendaftaran::whereIn('id_pendaftaran', $murid)
            ->get();

        $username_murid = [];
        for ($i = 0; $i < count($pendaftar); $i++) {
            array_push($username_murid, $pendaftar[$i]->username);
        }

        $data1 = \App\Jadwal_Kosong::join('hari', 'jadwal_kosong.id_hari', '=', 'hari.id_hari')
            ->where('status_kosong', 0)
            ->where('username', $username_murid[0])
        // ->groupBy('jadwal_kosong.id_sesi')
        // ->groupBy('jadwal_kosong.id_hari')
            ->get();

        $jadwal_kosong = [];

        $data = [];

        // > 1 Murid
        if (count($username_murid) > 1) {
            $jadwal_murid = \App\Jadwal_Kosong::join('hari', 'jadwal_kosong.id_hari', '=', 'hari.id_hari')
            ->where('status_kosong', 0)
            ->whereIn('username', $username_murid)
            ->get();
            
            for ($i = 0; $i < count($jadwal_murid) - 1; $i++) {
                $count = 0;
                for ($j = ($i+1); $j < count($jadwal_murid); $j++) {
                    if($jadwal_murid[$i]->id_sesi == $jadwal_murid[$j]->id_sesi && $jadwal_murid[$i]->id_hari == $jadwal_murid[$j]->id_hari){
                        $count++;
                        if($count == (count($username_murid)-1)){
                            array_push($jadwal_kosong, $jadwal_murid[$i]);
                        }
                    }
                }
            }
        }

        // 2 Murid
        // if (count($username_murid) == 2) {

        //     $data2 = \App\Jadwal_Kosong::join('hari', 'jadwal_kosong.id_hari', '=', 'hari.id_hari')
        //         ->where('status_kosong', 0)
        //         ->where('username', $username_murid[1])
        //         ->get();

        //     for ($i = 0; $i < count($data1); $i++) {
        //         for ($j = 0; $j < count($data2); $j++) {
        //             if ($data1[$i]->id_sesi == $data2[$j]->id_sesi && $data1[$i]->id_hari == $data2[$j]->id_hari) {
        //                 array_push($jadwal_kosong, $data1[$i]);
        //             }
        //             # code...

        //         }
        //     }
        // }
        else {
            $jadwal_kosong = $data1;
        }

        Header('Content-type: application/json');
        echo json_encode($jadwal_kosong);
        // die;

    }
    public function getJadwalOpsi(Request $request)
    {
        $murid = $request->murid;
        $id_hari = intval($request->get('id_hari'));
        $id_sesi = intval($request->get('id_sesi'));

        $pendaftar = \App\Pendaftaran::whereIn('id_pendaftaran', $murid)
            ->get();

        $username_murid = [];
        for ($i = 0; $i < count($pendaftar); $i++) {
            array_push($username_murid, $pendaftar[$i]->username);
        }

        $temp_jadwal_kosong = \App\Jadwal_Kosong::join('hari', 'jadwal_kosong.id_hari', '=', 'hari.id_hari')
            ->where('status_kosong', 0)
            ->where('username', $username_murid[0])
            ->where('id_sesi', $id_sesi)
            ->where('id_hari', $id_hari)
            ->orderBy('jadwal_kosong.id_sesi', 'asc')
            ->orderBy('jadwal_kosong.id_hari', 'asc')
            ->get()->first();

        $jadwal_kosong = \App\Jadwal_Kosong::join('hari', 'jadwal_kosong.id_hari', '=', 'hari.id_hari')
            ->where('status_kosong', 0)
            ->where('username', $username_murid[0])
        // ->whereNotIn('id_jadwal_kosong', $temp_jadwal_kosong->id_jadwal_kosong)
->orderBy('jadwal_kosong.id_sesi', 'asc')
            ->orderBy('jadwal_kosong.id_hari', 'asc')
            ->get();


        Header('Content-type: application/json');
        echo json_encode($jadwal_kosong);
        // die;

    }
    public function getSesi(Request $request)
    {
        $id_hari = intval($request->get('id_hari'));
        $murid = intval($request->get('murid'));

        $pendaftar = \App\Pendaftaran::where('id_pendaftaran', $murid)
            ->get()->first();


        $data = \App\Jadwal_Kosong::join('sesi_jam', 'jadwal_kosong.id_sesi', '=', 'sesi_jam.id_sesi')
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

    public function getSensei(Request $request)
    {
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
        $data1 = \App\Jadwal_Kosong::join('user', 'jadwal_kosong.username', '=', 'user.username')
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

        $data2 = \App\Jadwal_Kosong::join('user', 'jadwal_kosong.username', '=', 'user.username')
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

        for ($i = 0; $i < count($data1); $i++) {
            for ($j = 0; $j < count($data2); $j++) {
                if ($data1[$i]->username == $data2[$j]->username) {
                    array_push($username_sensei, $data1[$i]->username);
                }
                # code...

            }
        }

        $sensei = \App\Sensei::whereIn('username', $username_sensei)
            ->get();


        Header('Content-type: application/json');
        echo json_encode($sensei);
        // die;

    }

}