<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use DateTime;

class SenseiController extends Controller
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
        $data['header'] = "Sensei";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $sensei = DB::table('sensei')->where(['username' => session('username')])
        ->get()->first();
        $kelas = DB::table('kelas')->where('id_sensei', $sensei->id_sensei)->get();
        $data['jumlah_kelas'] = count($kelas);
        $jumlah_murid = 0;
        for ($i=0; $i < count($kelas); $i++) { 
            $kelas[$i]->peserta = DB::table('peserta_kelas')
            ->where('id_kelas', "=", $kelas[$i]->id_kelas)
            ->get();

            $jumlah_murid += count($kelas[$i]->peserta);
        }
        $data['jumlah_murid'] = $jumlah_murid;
        // Header('Content-type: application/json');
        // echo json_encode($jumlah_murid);
        // die;
        return view('sensei.dashboard', $data);
    }

    public function jadwalLes()
    {
        $data['title'] = "Jadwal Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        return view('sensei.jadwal_les', $data);
    }

    public function jadwalKosong()
    {
        $data['title'] = "Jadwal Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['jadwal_kosong'] = DB::table('jadwal_kosong')->where(['username' => session('username')])
        ->join('hari', 'hari.id_hari', '=', 'jadwal_kosong.id_hari')
        ->join('sesi_jam', 'sesi_jam.id_sesi', '=', 'jadwal_kosong.id_sesi')
        ->where('status_kosong', 0)
        ->orderBy('jadwal_kosong.id_hari', 'asc')
        ->orderBy('jadwal_kosong.id_sesi', 'asc')
        ->get();

        $data['sesi'] = DB::table('sesi_jam')->get();
        $data['hari'] = DB::table('hari')->get();
        return view('sensei.jadwal_kosong', $data);
    }

    public function tambahJadwalKosong(Request $request)
    {
        $username = $request->username;
        $hari = intval($request->hari);
        $sesi = intval($request->jam);
        $jadwal = DB::table('jadwal_kosong')
        ->where('username', $username)
        ->where('id_hari', $hari)
        ->where('id_sesi', $sesi)
        ->get();

        if ($jadwal->isEmpty()) {
            DB::insert('insert into jadwal_kosong (id_sesi, id_hari, username) values (?, ?, ?)', [$sesi, $hari, $username]);
            return redirect('/sensei/jadwalKosong')->with('status', 'Penambahan jadwal kosong berhasil');
        } else {
            return redirect('/sensei/jadwalKosong')->with('status', 'Jadwal kosong sudah ada / Jadwal tidak kosong');
        }
    }

    public function scoreboard(){
        $data['title'] = "Scoreboard";
        $data['header'] = "Sensei";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        return view('sensei.scoreboard', $data);
    }

    public function pembelajaran(){
        $data['title'] = "Pembelajaran";
        $data['header'] = "Sensei";
        $sensei = DB::table('sensei')->where(['username' => session('username')])
        ->get()->first();

        $data['kelas_berjalan'] = DB::table('kelas')
        // ->join('peserta_kelas', 'peserta_kelas.id_kelas', '=', 'kelas.id_kelas')
        // ->join('pendaftaran', 'peserta_kelas.username', '=', 'pendaftaran.username')
        // ->join('program_les', 'program_les.id_program_les', '=', 'pendaftaran.id_program_les')
        ->where('kelas.id_sensei', $sensei->id_sensei)
        // ->where('pendaftaran.status_pendaftaran', 1)
        // ->groupBy('pendaftaran.id_program_les')
        ->get();

        // Header('Content-type: application/json');
        // echo json_encode($data['kelas_berjalan']);
        // die;

        for ($i=0; $i < count($data['kelas_berjalan']); $i++) { 

            $data['kelas_berjalan'][$i]->peserta = DB::table('peserta_kelas')
            ->join('pendaftaran', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
            ->join('program_les', 'program_les.id_program_les', '=', 'pendaftaran.id_program_les')
            ->where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
            ->get();

            $data['kelas_berjalan'][$i]->pertemuan = DB::table('pertemuan')
            ->where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
            ->get();

            $data['kelas_berjalan'][$i]->jumlah_pertemuan = $data['kelas_berjalan'][$i]->peserta[0]->jumlah_pertemuan;
            $data['kelas_berjalan'][$i]->image = $data['kelas_berjalan'][$i]->peserta[0]->image;
            $data['kelas_berjalan'][$i]->nama_program_les = $data['kelas_berjalan'][$i]->peserta[0]->nama_program_les;
            
            $data['kelas_berjalan'][$i]->jadwal = DB::table('jadwal_kelas')
            ->join('hari', 'hari.id_hari', '=', 'jadwal_kelas.id_hari')
            ->join('sesi_jam', 'sesi_jam.id_sesi', '=', 'jadwal_kelas.id_sesi')
            ->where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
            ->get();
        }

        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        // Header('Content-type: application/json');
        // echo json_encode($data);die;
        return view('sensei.pembelajaran', $data);
    }

    public function detailPembelajaran($id)
    {
        $data['title'] = "Pembelajaran";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['detail_kelas'] = DB::table('kelas')->where(['kelas.id_kelas' => intval($id)])
        ->join('peserta_kelas', 'kelas.id_kelas', '=', 'peserta_kelas.id_kelas')    
        ->join('pendaftaran', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
        ->join('program_les', 'program_les.id_program_les', '=', 'pendaftaran.id_program_les')
        ->join('sensei', 'kelas.id_sensei', '=', 'sensei.id_sensei')
        ->where('pendaftaran.status_pendaftaran', 1)
        ->get()->first();

        $data['detail_kelas']->peserta = DB::table('peserta_kelas')
        ->join('murid', 'murid.username', '=', 'peserta_kelas.username')
        ->where('id_kelas', "=", $id)
        ->get();

        for ($i=0; $i < count($data['detail_kelas']->peserta) ; $i++) { 
            $id_peserta_kelas = $data['detail_kelas']->peserta[$i]->id_peserta_kelas;
            $data['detail_kelas']->peserta[$i]->jumlah_hadir = DB::table('kehadiran_peserta')
            ->where('id_peserta', "=", $id_peserta_kelas)
            ->where('kehadiran', "=", 1)
            ->get()->count();

        }
        
        $data['detail_kelas']->pertemuan = DB::table('pertemuan')
        ->where('id_kelas', "=", $id)
        ->get();

        for ($i=0; $i < count($data['detail_kelas']->pertemuan) ; $i++) { 
            $data['detail_kelas']->pertemuan[$i]->tanggal_indo = $this->tanggal($data['detail_kelas']->pertemuan[$i]->tanggal);
        }

        $data['detail_kelas']->jadwal = DB::table('jadwal_kelas')
        ->join('hari', 'hari.id_hari', '=', 'jadwal_kelas.id_hari')
        ->join('sesi_jam', 'sesi_jam.id_sesi', '=', 'jadwal_kelas.id_sesi')
        ->where('id_kelas', "=", $data['detail_kelas']->id_kelas)
        ->get();

        // Header('Content-type: application/json');
        // echo json_encode($data['detail_kelas']);die;
        return view('sensei.detail_kelas', $data);
    }

    public function getMurid($username){
        $data = DB::table('murid')->where(['murid.username' => $username])
        ->join('user', 'user.username', '=', 'murid.username')
        ->get()->first();

        Header('Content-type: application/json');
        echo json_encode($data);
    }

    public function getDetailPeserta($id){
        $data = DB::table('peserta_kelas')->where(['id_peserta_kelas' => $id])
        ->join('murid', 'peserta_kelas.username', '=', 'murid.username')
        ->get()->first();

        Header('Content-type: application/json');
        echo json_encode($data);
    }

    public function getKehadiranPeserta($id){
        $data = DB::table('kehadiran_peserta')->where(['id_pertemuan' => $id])
        ->join('peserta_kelas', 'peserta_kelas.id_peserta_kelas', '=', 'kehadiran_peserta.id_peserta')
        ->join('murid', 'peserta_kelas.username', '=', 'murid.username')
        ->get();

        Header('Content-type: application/json');
        echo json_encode($data);
    }

    public function tambahLaporan($id)
    {
        $data['title'] = "Pembelajaran";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['detail_kelas'] = DB::table('kelas')->where(['kelas.id_kelas' => intval($id)])
        ->join('peserta_kelas', 'kelas.id_kelas', '=', 'peserta_kelas.id_kelas')    
        ->join('pendaftaran', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
        ->join('program_les', 'program_les.id_program_les', '=', 'pendaftaran.id_program_les')
        ->join('sensei', 'kelas.id_sensei', '=', 'sensei.id_sensei')
        ->join('jadwal_kelas', 'kelas.id_kelas', '=', 'jadwal_kelas.id_kelas')
        ->join('hari', 'hari.id_hari', '=', 'jadwal_kelas.id_hari')
        ->join('sesi_jam', 'sesi_jam.id_sesi', '=', 'jadwal_kelas.id_sesi')
        ->where('pendaftaran.status_pendaftaran', 1)
        ->get()->first();

        $data['detail_kelas']->peserta = DB::table('peserta_kelas')
        ->join('murid', 'murid.username', '=', 'peserta_kelas.username')
        ->where('id_kelas', "=", $id)
        ->get();
        
        $data['detail_kelas']->pertemuan = DB::table('pertemuan')
        ->where('id_kelas', "=", $id)
        ->get();

        $data['detail_kelas']->jumlah_pertemuan = count($data['detail_kelas']->pertemuan);
        return view('sensei.tambah_Laporan', $data);
    }

    public function tambahLaporanKelas(Request $request, $id)
    {
        
        $data['id_kelas'] = $request->id_kelas;
        $data['pertemuan'] = $request->pertemuan;
        $data['tanggal'] = $request->tanggal;
        $data['deskripsi'] = $request->deskripsi;
        $data['kehadiran'] = $request->kehadiran;

        $data['tidak_hadir'] = DB::table('peserta_kelas')
        ->whereNotIn('id_peserta_kelas', $data['kehadiran'])
        ->get();

        DB::insert('insert into pertemuan (pertemuan_ke, tanggal, deskripsi, id_kelas) values (?, ?, ?, ?)', [$data['pertemuan'], $data['tanggal'], $data['deskripsi'], $data['id_kelas']]);

        $pertemuan = DB::table('pertemuan')
        ->where('pertemuan_ke', $data['pertemuan'])
        ->where('deskripsi', $data['deskripsi'])
        ->where('id_kelas', $data['id_kelas'])
        ->get()->first();

        $kehadiran_peserta = [];
        if($data['kehadiran'] != null){
            for ($i=0; $i < count($data['kehadiran']) ; $i++) { 
                $hadir = [
                    'id_peserta' => intval($data['kehadiran'][$i]),
                    'id_pertemuan' => intval($pertemuan->id_pertemuan),
                    'kehadiran' => 1
                ];
    
                array_push($kehadiran_peserta, $hadir);
            }
        }
        
        if($data['tidak_hadir']->isEmpty()){

        }
        else{
            for ($i=0; $i < count($data['tidak_hadir']) ; $i++) { 
                $tidak_hadir = [
                    'id_peserta' => intval($data['tidak_hadir'][$i]->id_peserta_kelas),
                    'id_pertemuan' => intval($pertemuan->id_pertemuan),
                    'kehadiran' => 0
                ];
    
                array_push($kehadiran_peserta, $tidak_hadir);
            }
        }

        DB::table('kehadiran_peserta')->insert($kehadiran_peserta);

        return redirect('/sensei/pembelajaran/'.$id)->with('status', 'Laporan berhasil ditambahkan');
    }

    public function editNilai(Request $request)
    {
        
        $id_peserta_kelas = $request->id_peserta_kelas;
        $id_kelas = $request->id_kelas;
        $nilai_evaluasi = $request->nilai_evaluasi;

        DB::update('update peserta_kelas set nilai_evaluasi = ? where id_peserta_kelas = ?', [$nilai_evaluasi, intval($id_peserta_kelas)]);

        return redirect('/sensei/pembelajaran/'.$id_kelas)->with('status', 'Nilai Evaluasi berhasil diperbarui');
    }

    public function getJadwal(){
        $sensei = DB::table('sensei')->where(['username' => session('username')])
        ->get()->first();

        $data['kelas_berjalan'] = DB::table('pendaftaran')
        ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
        ->join('peserta_kelas', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
        ->join('kelas', 'peserta_kelas.id_kelas', '=', 'kelas.id_kelas')
        ->where('pendaftaran.status_pendaftaran', 1)
        ->where('kelas.id_sensei', $sensei->id_sensei)
        // ->groupBy('kelas.id_kelas')
        ->get();

        for ($i=0; $i < count($data['kelas_berjalan']); $i++) { 
            // array_push($data['kelas_berjalan'][0]->peserta_kelas, "AA");
            $data['kelas_berjalan'][$i]->peserta = DB::table('peserta_kelas')
            ->where(['username' => session('username')])
            ->where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
            ->get();

            $data['kelas_berjalan'][$i]->pertemuan = DB::table('pertemuan')
            ->where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
            ->get();

            $data['kelas_berjalan'][$i]->jadwal = DB::table('jadwal_kelas')
            ->join('hari', 'hari.id_hari', '=', 'jadwal_kelas.id_hari')
            ->join('sesi_jam', 'sesi_jam.id_sesi', '=', 'jadwal_kelas.id_sesi')
            ->where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
            ->get();

            for ($j=0; $j < count($data['kelas_berjalan'][$i]->jadwal); $j++) { 
                $date1 = new DateTime(date('Y-m-d') . 'T' . $data['kelas_berjalan'][$i]->jadwal[$j]->jam_mulai);
                $date2 = new DateTime(date('Y-m-d') . 'T' . $data['kelas_berjalan'][$i]->jadwal[$j]->jam_selesai);
                $diff = $date2->diff($date1);
                $data['kelas_berjalan'][$i]->jadwal[$j]->durasi = $diff->format('%H:%I:%S');

                if($data['kelas_berjalan'][$i]->jadwal[$j]->id_hari == 1){
                    $data['kelas_berjalan'][$i]->jadwal[$j]->day = "MO";
                }
                elseif($data['kelas_berjalan'][$i]->jadwal[$j]->id_hari == 2){
                    $data['kelas_berjalan'][$i]->jadwal[$j]->day = "TU";
                }
                elseif($data['kelas_berjalan'][$i]->jadwal[$j]->id_hari == 3){
                    $data['kelas_berjalan'][$i]->jadwal[$j]->day = "WE";
                }
                elseif($data['kelas_berjalan'][$i]->jadwal[$j]->id_hari == 4){
                    $data['kelas_berjalan'][$i]->jadwal[$j]->day = "TH";
                }
                elseif($data['kelas_berjalan'][$i]->jadwal[$j]->id_hari == 5){
                    $data['kelas_berjalan'][$i]->jadwal[$j]->day = "FR";
                }
                elseif($data['kelas_berjalan'][$i]->jadwal[$j]->id_hari == 6){
                    $data['kelas_berjalan'][$i]->jadwal[$j]->day = "SA";
                }
                else{
                    $data['kelas_berjalan'][$i]->jadwal[$j]->day = "SU";
                }
                // $nameOfDay = date('D', strtotime(date('Y-m-d')));
                // $hari = strtoupper(substr($nameOfDay, 0, 2));

                // echo json_encode($hari);die;
            }

        }

        Header('Content-type: application/json');
        echo json_encode($data);
    }
}
