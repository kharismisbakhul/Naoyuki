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

    // public function notif(){
    //     $data['notif'] = DB::table('kelas')
    //     ->where('kelas.id_sensei', $sensei->id_sensei)

    //     DB::table('pendaftaran')
    //     ->join('murid', 'pendaftaran.username', '=', 'murid.username')
    //     ->join('program_les', 'program_les.id_program_les', '=', 'pendaftaran.id_program_les')
    //     ->where('pendaftaran.status_pendaftaran', 1)
    //     ->orderBy('pendaftaran.tanggal_pendaftaran', 'asc')
    //     ->orderBy('pendaftaran.waktu_pendaftaran', 'asc')
    //     ->get();

    //     for ($i=0; $i < count($data['notif']); $i++) { 
    //         $data['notif'][$i]->tgl_indo = $this->tanggal($data['notif'][$i]->tanggal_pendaftaran);
    //     }
        
    //     $data['count_notif'] = count($data['notif']);
    //     return $data;
    // }

    public function index()
    {
        $data['title'] = "Dashboard";
        $data['header'] = "Sensei";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $sensei = \App\Sensei::where(['username' => session('username')])
            ->get()->first();
        $kelas = \App\Kelas::where('id_sensei', $sensei->id_sensei)->get();
        $data['jumlah_kelas'] = count($kelas);
        $jumlah_murid = 0;
        for ($i = 0; $i < count($kelas); $i++) {
            $kelas[$i]->peserta = \App\Peserta_Kelas::where('id_kelas', "=", $kelas[$i]->id_kelas)
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
        $data['jadwal_kosong'] = \App\Jadwal_Kosong::where(['username' => session('username')])
            ->join('hari', 'hari.id_hari', '=', 'jadwal_kosong.id_hari')
            ->join('sesi_jam', 'sesi_jam.id_sesi', '=', 'jadwal_kosong.id_sesi')
            ->where('status_kosong', 0)
            ->orderBy('jadwal_kosong.id_hari', 'asc')
            ->orderBy('jadwal_kosong.id_sesi', 'asc')
            ->get();

        $data['sesi'] = \App\Sesi_Jam::all();
        $data['hari'] = \App\Hari::all();
        return view('sensei.jadwal_kosong', $data);
    }

    public function tambahJadwalKosong(Request $request)
    {
        if ($request->hari == "" && $request->sesi == "") {
            return redirect('/sensei/jadwalKosong')->with('gagal', 'Hari dan Jam tidak boleh kosong');
        }
        else if ($request->sesi == "") {
            return redirect('/sensei/jadwalKosong')->with('gagal', 'Jam tidak boleh kosong');
        }
        else {
            return redirect('/sensei/jadwalKosong')->with('gagal', 'Hari tidak boleh kosong');
        }

        $username = $request->username;
        $hari = intval($request->hari);
        $sesi = intval($request->jam);
        $jadwal = \App\Jadwal_Kosong::where('username', $username)
            ->where('id_hari', $hari)
            ->where('id_sesi', $sesi)
            ->get();

        $jadwal_tidak_kosong = \App\Jadwal_Kosong::where('username', $username)
            ->where('id_hari', $hari)
            ->where('id_sesi', $sesi)
            ->where('status_kosong', 1)
            ->get();

        if ($jadwal->isEmpty()) {
            \App\Jadwal_Kosong::insert([
                'id_sesi' => $sesi,
                'id_hari' => $hari,
                'username' => $username
            ]);
            return redirect('/sensei/jadwalKosong')->with('status', 'Penambahan jadwal kosong berhasil');
        }
        else {
            if ($jadwal_tidak_kosong->isEmpty()) {
                return redirect('/sensei/jadwalKosong')->with('gagal', 'Jadwal kosong sudah ada');
            }
            else {
                return redirect('/sensei/jadwalKosong')->with('gagal', 'Jadwal tidak kosong');
            }
        }
    }

    // public function scoreboard(){
    //     $data['title'] = "Scoreboard";
    //     $data['header'] = "Sensei";
    //     $data['tanggal'] = $this->tanggal(date('Y-m-d'));
    //     return view('sensei.scoreboard', $data);
    // }

    public function pembelajaran()
    {
        $data['title'] = "Pembelajaran";
        $data['header'] = "Sensei";
        $sensei = \App\Sensei::where(['username' => session('username')])
            ->get()->first();

        $data['kelas_berjalan'] = \App\Kelas::where('kelas.id_sensei', $sensei->id_sensei)
        // ->join('peserta_kelas', 'peserta_kelas.id_kelas', '=', 'kelas.id_kelas')
        // ->join('pendaftaran', 'peserta_kelas.username', '=', 'pendaftaran.username')
        // ->join('program_les', 'program_les.id_program_les', '=', 'pendaftaran.id_program_les')
        // ->where('pendaftaran.status_pendaftaran', 1)
        // ->groupBy('pendaftaran.id_program_les')
->get();

        // Header('Content-type: application/json');
        // echo json_encode($data['kelas_berjalan']);
        // die;

        for ($i = 0; $i < count($data['kelas_berjalan']); $i++) {

            $data['kelas_berjalan'][$i]->peserta = \App\Peserta_Kelas::join('pendaftaran', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
                ->join('program_les', 'program_les.id_program_les', '=', 'pendaftaran.id_program_les')
                ->where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
                ->get();

            $data['kelas_berjalan'][$i]->pertemuan = \App\Pertemuan::where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
                ->get();

            // Header('Content-type: application/json');
            // echo json_encode(count($data['kelas_berjalan']));
            // die;

            if (count($data['kelas_berjalan']) != 0) {
                $data['kelas_berjalan'][$i]->jumlah_pertemuan = $data['kelas_berjalan'][$i]->peserta[0]->jumlah_pertemuan;
                $data['kelas_berjalan'][$i]->image = $data['kelas_berjalan'][$i]->peserta[0]->image;
                $data['kelas_berjalan'][$i]->nama_program_les = $data['kelas_berjalan'][$i]->peserta[0]->nama_program_les;
            }

            $data['kelas_berjalan'][$i]->jadwal = \App\Jadwal_Kelas::where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
                ->join('hari', 'hari.id_hari', '=', 'jadwal_kelas.id_hari')
                ->join('sesi_jam', 'sesi_jam.id_sesi', '=', 'jadwal_kelas.id_sesi')
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
        $data['detail_kelas'] = \App\Kelas::where(['kelas.id_kelas' => intval($id)])
            ->join('peserta_kelas', 'kelas.id_kelas', '=', 'peserta_kelas.id_kelas')
            ->join('pendaftaran', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
            ->join('program_les', 'program_les.id_program_les', '=', 'pendaftaran.id_program_les')
            ->join('sensei', 'kelas.id_sensei', '=', 'sensei.id_sensei')
            ->where('pendaftaran.status_pendaftaran', 1)
            ->get()->first();

        $data['detail_kelas']->peserta = \App\Peserta_Kelas::where('id_kelas', "=", $id)
            ->join('murid', 'murid.username', '=', 'peserta_kelas.username')
            ->get();

        for ($i = 0; $i < count($data['detail_kelas']->peserta); $i++) {
            $id_peserta_kelas = $data['detail_kelas']->peserta[$i]->id_peserta_kelas;
            $data['detail_kelas']->peserta[$i]->jumlah_hadir = \App\Kehadiran_Peserta::where('id_peserta', "=", $id_peserta_kelas)
                ->where('kehadiran', "=", 1)
                ->get()->count();

        }

        $data['detail_kelas']->pertemuan = \App\Pertemuan::where('id_kelas', "=", $id)
            ->get();

        for ($i = 0; $i < count($data['detail_kelas']->pertemuan); $i++) {
            $data['detail_kelas']->pertemuan[$i]->tanggal_indo = $this->tanggal($data['detail_kelas']->pertemuan[$i]->tanggal);
        }

        $data['detail_kelas']->jadwal = \App\Jadwal_Kelas::where('id_kelas', "=", $data['detail_kelas']->id_kelas)
            ->join('hari', 'hari.id_hari', '=', 'jadwal_kelas.id_hari')
            ->join('sesi_jam', 'sesi_jam.id_sesi', '=', 'jadwal_kelas.id_sesi')
            ->get();

        // Header('Content-type: application/json');
        // echo json_encode($data['detail_kelas']);die;
        return view('sensei.detail_kelas', $data);
    }

    public function getMurid($username)
    {
        $data = \App\Murid::where(['murid.username' => $username])
            ->join('user', 'user.username', '=', 'murid.username')
            ->get()->first();

        Header('Content-type: application/json');
        echo json_encode($data);
    }

    public function getDetailPeserta($id)
    {
        $data = \App\Peserta_Kelas::where(['id_peserta_kelas' => $id])
            ->join('murid', 'peserta_kelas.username', '=', 'murid.username')
            ->get()->first();

        Header('Content-type: application/json');
        echo json_encode($data);
    }

    public function getKehadiranPeserta($id)
    {
        $data['kehadiran'] = \App\Kehadiran_Peserta::where(['id_pertemuan' => $id])
            ->join('peserta_kelas', 'peserta_kelas.id_peserta_kelas', '=', 'kehadiran_peserta.id_peserta')
        // ->join('pertemuan', 'pertemuan.id_pertemuan', '=', 'kehadiran_peserta.id_pertemuan')
->join('murid', 'peserta_kelas.username', '=', 'murid.username')
            ->get();

        $data['pertemuan'] = \App\Pertemuan::where(['id_pertemuan' => $id])
            ->get()->first();

        Header('Content-type: application/json');
        echo json_encode($data);
    }

    public function tambahLaporan($id)
    {
        $data['title'] = "Pembelajaran";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['detail_kelas'] = \App\Kelas::where(['kelas.id_kelas' => intval($id)])
            ->join('peserta_kelas', 'kelas.id_kelas', '=', 'peserta_kelas.id_kelas')
            ->join('pendaftaran', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
            ->join('program_les', 'program_les.id_program_les', '=', 'pendaftaran.id_program_les')
            ->join('sensei', 'kelas.id_sensei', '=', 'sensei.id_sensei')
        // ->join('jadwal_kelas', 'kelas.id_kelas', '=', 'jadwal_kelas.id_kelas')
        // ->join('hari', 'hari.id_hari', '=', 'jadwal_kelas.id_hari')
        // ->join('sesi_jam', 'sesi_jam.id_sesi', '=', 'jadwal_kelas.id_sesi')
->where('pendaftaran.status_pendaftaran', 1)
            ->get()->first();

        $data['detail_kelas']->peserta = \App\Peserta_Kelas::where('id_kelas', "=", $id)
            ->join('murid', 'murid.username', '=', 'peserta_kelas.username')
            ->get();

        $data['detail_kelas']->pertemuan = \App\Pertemuan::where('id_kelas', "=", $id)
            ->get();

        $data['detail_kelas']->jumlah_pertemuan_hadir = count($data['detail_kelas']->pertemuan);

        return view('sensei.tambah_Laporan', $data);
    }

    public function tambahLaporanKelas(Request $request, $id)
    {

        $request->validate([
            'tanggal' => 'required',
            'deskripsi' => 'required'
        ], [
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong'
        ]);
        
        $data['id_kelas'] = $request->id_kelas;
        $data['total_hadir'] = $request->jumlah_pertemuan;
        $data['pertemuan'] = $request->pertemuan;
        $data['tanggal'] = $request->tanggal;
        $data['deskripsi'] = $request->deskripsi;
        $data['kehadiran'] = $request->kehadiran;

        $data['tidak_hadir'] = \App\Peserta_Kelas::whereNotIn('id_peserta_kelas', $data['kehadiran'])
        ->where('id_kelas', $data['id_kelas'])
        ->get();

        \App\Pertemuan::insert([
            'pertemuan_ke' => $data['pertemuan'],
            'tanggal' => $data['tanggal'],
            'deskripsi' => $data['deskripsi'],
            'id_kelas' => $data['id_kelas']
        ]);

        $pertemuan = \App\Pertemuan::where('pertemuan_ke', $data['pertemuan'])
            ->where('deskripsi', $data['deskripsi'])
            ->where('id_kelas', $data['id_kelas'])
            ->get()->first();

        $kehadiran_peserta = [];

        if ($data['kehadiran'] != null) {
            for ($i = 0; $i < count($data['kehadiran']); $i++) {
                $hadir = [
                    'id_peserta' => intval($data['kehadiran'][$i]),
                    'id_pertemuan' => intval($pertemuan->id_pertemuan),
                    'kehadiran' => 1
                ];

                if ($data['total_hadir'] == $data['pertemuan']) {
                    \App\Peserta_Kelas::where('id_peserta_kelas', intval($data['kehadiran'][$i]))
                        ->update(['status_les' => 1]);
                }
                array_push($kehadiran_peserta, $hadir);
            }
        }

        if (count($data['tidak_hadir'])!= 0) {
            for ($i = 0; $i < count($data['tidak_hadir']); $i++) {
                $tidak_hadir = [
                    'id_peserta' => intval($data['tidak_hadir'][$i]->id_peserta_kelas),
                    'id_pertemuan' => intval($pertemuan->id_pertemuan),
                    'kehadiran' => 0
                ];
    
                array_push($kehadiran_peserta, $tidak_hadir);
            }
        }

        \App\Kehadiran_Peserta::insert($kehadiran_peserta);

        return redirect('/sensei/pembelajaran/' . $id)->with('status', 'Laporan berhasil ditambahkan');
    }

    public function editNilai(Request $request)
    {

        $id_peserta_kelas = $request->id_peserta_kelas;
        $id_kelas = $request->id_kelas;
        $nilai_evaluasi = $request->nilai_evaluasi;

        \App\Peserta_Kelas::where('id_peserta_kelas', intval($id_peserta_kelas))
            ->update(['nilai_evaluasi' => $nilai_evaluasi]);

        // DB::update('update peserta_kelas set nilai_evaluasi = ? where id_peserta_kelas = ?', [$nilai_evaluasi, intval($id_peserta_kelas)]);

        return redirect('/sensei/pembelajaran/' . $id_kelas)->with('status', 'Nilai Evaluasi berhasil diperbarui');
    }

    public function getJadwal()
    {
        $sensei = \App\Sensei::where(['username' => session('username')])
            ->get()->first();

        $data['kelas_berjalan'] = \App\Pendaftaran::join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
            ->join('peserta_kelas', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
            ->join('kelas', 'peserta_kelas.id_kelas', '=', 'kelas.id_kelas')
            ->where('pendaftaran.status_pendaftaran', 1)
            ->where('kelas.id_sensei', $sensei->id_sensei)
        // ->groupBy('kelas.id_kelas')
->get();

        for ($i = 0; $i < count($data['kelas_berjalan']); $i++) { 
            // array_push($data['kelas_berjalan'][0]->peserta_kelas, "AA");
            $data['kelas_berjalan'][$i]->peserta = \App\Peserta_Kelas::where(['username' => session('username')])
                ->where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
                ->get();

            $data['kelas_berjalan'][$i]->pertemuan = \App\Pertemuan::where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
                ->get();

            $data['kelas_berjalan'][$i]->jadwal = \App\Jadwal_Kelas::where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
                ->join('hari', 'hari.id_hari', '=', 'jadwal_kelas.id_hari')
                ->join('sesi_jam', 'sesi_jam.id_sesi', '=', 'jadwal_kelas.id_sesi')
                ->get();

            for ($j = 0; $j < count($data['kelas_berjalan'][$i]->jadwal); $j++) {
                $date1 = new DateTime(date('Y-m-d') . 'T' . $data['kelas_berjalan'][$i]->jadwal[$j]->jam_mulai);
                $date2 = new DateTime(date('Y-m-d') . 'T' . $data['kelas_berjalan'][$i]->jadwal[$j]->jam_selesai);
                $diff = $date2->diff($date1);
                $data['kelas_berjalan'][$i]->jadwal[$j]->durasi = $diff->format('%H:%I:%S');

                if ($data['kelas_berjalan'][$i]->jadwal[$j]->id_hari == 1) {
                    $data['kelas_berjalan'][$i]->jadwal[$j]->day = "MO";
                }
                elseif ($data['kelas_berjalan'][$i]->jadwal[$j]->id_hari == 2) {
                    $data['kelas_berjalan'][$i]->jadwal[$j]->day = "TU";
                }
                elseif ($data['kelas_berjalan'][$i]->jadwal[$j]->id_hari == 3) {
                    $data['kelas_berjalan'][$i]->jadwal[$j]->day = "WE";
                }
                elseif ($data['kelas_berjalan'][$i]->jadwal[$j]->id_hari == 4) {
                    $data['kelas_berjalan'][$i]->jadwal[$j]->day = "TH";
                }
                elseif ($data['kelas_berjalan'][$i]->jadwal[$j]->id_hari == 5) {
                    $data['kelas_berjalan'][$i]->jadwal[$j]->day = "FR";
                }
                elseif ($data['kelas_berjalan'][$i]->jadwal[$j]->id_hari == 6) {
                    $data['kelas_berjalan'][$i]->jadwal[$j]->day = "SA";
                }
                else {
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
