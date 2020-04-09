<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Murid;
use DateTime;

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
        $data['program_berjalan'] = DB::table('pendaftaran')
            ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
            ->where('pendaftaran.username', session('username'))
            ->groupBy('pendaftaran.id_program_les')
            ->get();

        // Header('Content-type: application/json');
        // echo json_encode($data['program_berjalan']);
        // die;

        // Kehadiran
        $kehadiran = DB::table('kehadiran_peserta')
        ->select(DB::raw('COUNT(id_kehadiran) as jumlah_kehadiran'))
        ->where('id_peserta', 1)
        ->get();

        $data['kelas_berjalan'] = DB::table('pendaftaran')->where(['pendaftaran.username' => session('username')])
            ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
            ->join('peserta_kelas', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
            ->join('kelas', 'peserta_kelas.id_kelas', '=', 'kelas.id_kelas')
            ->where('pendaftaran.status_pendaftaran', 1)
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
        }

            // Header('Content-type: application/json');
            // echo json_encode($data['kelas_berjalan'][0]);die;
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
        $data['jadwal_kosong'] = DB::table('jadwal_kosong')->where(['username' => session('username')])
        ->join('hari', 'hari.id_hari', '=', 'jadwal_kosong.id_hari')
        ->join('sesi_jam', 'sesi_jam.id_sesi', '=', 'jadwal_kosong.id_sesi')
        ->where('status_kosong', 0)
        ->orderBy('jadwal_kosong.id_hari', 'asc')
        ->orderBy('jadwal_kosong.id_sesi', 'asc')
        ->get();

        $data['sesi'] = DB::table('sesi_jam')->get();
        $data['hari'] = DB::table('hari')->get();
        return view('murid.jadwal_kosong', $data);
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
            return redirect('/murid/jadwalKosong')->with('status', 'Penambahan jadwal kosong berhasil');
        } else {
            return redirect('/murid/jadwalKosong')->with('status', 'Jadwal kosong sudah ada / Jadwal tidak kosong');
        }
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
        $status = Murid::daftar($request);
        if ($status == true) {
            return redirect('/murid/pembayaran/' . $status->id_pendaftaran)->with('status', 'Pendaftaran berhasil, silahkan melakukan pembayaran');
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

        $data['kelas_berjalan'] = DB::table('pendaftaran')->where(['pendaftaran.username' => session('username')])
        ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
        ->join('peserta_kelas', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
        ->join('kelas', 'peserta_kelas.id_kelas', '=', 'kelas.id_kelas')
        ->where('pendaftaran.status_pendaftaran', 1)
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
        }

        // Header('Content-type: application/json');
        // echo json_encode($data['kelas_berjalan']);die;
        
        return view('murid.pembelajaran', $data);
    }

    public function getJadwal(){
        $data['kelas_berjalan'] = DB::table('pendaftaran')->where(['pendaftaran.username' => session('username')])
        ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
        ->join('peserta_kelas', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
        ->join('kelas', 'peserta_kelas.id_kelas', '=', 'kelas.id_kelas')
        ->where('pendaftaran.status_pendaftaran', 1)
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

    public function detailPembelajaran($id)
    {
        $data['title'] = "Pembelajaran";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['detail_kelas'] = DB::table('pendaftaran')->where(['pendaftaran.username' => session('username')])
        ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
        ->join('peserta_kelas', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
        ->join('kelas', 'peserta_kelas.id_kelas', '=', 'kelas.id_kelas')
        ->where('pendaftaran.status_pendaftaran', 1)
        ->where('kelas.id_kelas', intval($id))
        ->get()->first();

            $data['detail_kelas']->pertemuan = DB::table('pertemuan')
            ->join('kehadiran_peserta', 'kehadiran_peserta.id_pertemuan', '=', 'pertemuan.id_pertemuan')
            ->where('id_kelas', "=", $data['detail_kelas']->id_kelas)
            ->where('id_peserta', "=", $data['detail_kelas']->id_peserta_kelas)
            ->get();

        // Header('Content-type: application/json');
        // echo json_encode($data['detail_kelas']);die;
        return view('murid.detail_pembelajaran', $data);
    }

    public function tambahFeedback(Request $request)
    {
        DB::update('update kehadiran_peserta set feedback = ? where id_kehadiran = ?', [$request->feedback, intval($request->id_kehadiran)]);
        
        return redirect('/murid/pembelajaran/'.$request->id_kelas)->with('status', 'Feedback berhasil ditambahkan');
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
        if ($request->email == null || $request->no_telp == null || $request->asal_sekolah == null || $request->alamat == null) {
            return redirect('/murid/profil')->with('gagal', 'Profil gagal diperbarui');
        } else {
            Murid::editProfil($request);
            return redirect('/murid/profil')->with('status', 'Data berhasil diperbarui');
        }
    }

    public function getFeedbackKelas($id){
        $data = DB::table('kehadiran_peserta')->where(['id_kehadiran' => intval($id)])
        ->join('pertemuan', 'kehadiran_peserta.id_pertemuan', '=', 'pertemuan.id_pertemuan')
        ->get()->first();

        Header('Content-type: application/json');
        echo json_encode($data);
    }
}
