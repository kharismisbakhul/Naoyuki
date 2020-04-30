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
        $data['program_berjalan'] = \App\Pendaftaran::where('pendaftaran.username', session('username'))
            ->where('pendaftaran.status_pendaftaran', 1)->with('program_les')
            ->groupBy('pendaftaran.id_program_les')
            ->get();

        $data['kelas_berjalan'] = \App\Pendaftaran::where(['pendaftaran.username' => session('username')])
            // ->with('program_les', 'peserta_kelas')
            ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
            ->join('peserta_kelas', 'pendaftaran.id_pendaftaran', '=', 'peserta_kelas.id_pendaftaran')
            ->join('kelas', 'peserta_kelas.id_kelas', '=', 'kelas.id_kelas')
            ->where('pendaftaran.status_pendaftaran', 1)
            ->get();

        for ($i=0; $i < count($data['kelas_berjalan']); $i++) { 
            // array_push($data['kelas_berjalan'][0]->peserta_kelas, "AA");
            $data['kelas_berjalan'][$i]->peserta = \App\Peserta_Kelas::where(['username' => session('username')])
            ->where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
            ->get();

            $data['kelas_berjalan'][$i]->pertemuan = \App\Pertemuan::where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
            ->get();
        }

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
        $data['jadwal_kosong'] = \App\Jadwal_Kosong::where(['username' => session('username')])
        ->with('hari', 'sesi')
        ->where('status_kosong', 0)
        ->orderBy('jadwal_kosong.id_hari', 'asc')
        ->orderBy('jadwal_kosong.id_sesi', 'asc')
        ->get();

        $data['sesi'] = \App\Sesi_Jam::all();
        $data['hari'] = \App\Hari::all();
        return view('murid.jadwal_kosong', $data);
    }

    public function tambahJadwalKosong(Request $request)
    {
        if($request->hari == "" && $request->jam == ""){
            return redirect('/murid/jadwalKosong')->with('gagal', 'Hari dan Jam tidak boleh kosong');
        }
        else if($request->jam == ""){
            return redirect('/murid/jadwalKosong')->with('gagal', 'Jam tidak boleh kosong');
        }
        else if($request->hari == ""){
            return redirect('/murid/jadwalKosong')->with('gagal', 'Hari tidak boleh kosong');
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
            return redirect('/murid/jadwalKosong')->with('status', 'Penambahan jadwal kosong berhasil');
        } else {
            if($jadwal_tidak_kosong->isEmpty()){
                return redirect('/murid/jadwalKosong')->with('gagal', 'Jadwal kosong sudah ada');
            }
            else{
                return redirect('/murid/jadwalKosong')->with('gagal', 'Jadwal tidak kosong');
            }
        }
    }

    public function programLes()
    {
        $data['title'] = "Program Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['program_les'] = \App\Program_Les::all();
        $data['program_berjalan'] = \App\Pendaftaran::where(['username' => session('username')])
            ->with('program_les')->get();
        return view('murid.program_les', $data);
    }

    public function getProgramTerdaftar($id)
    {
        $program_les = \App\Pendaftaran::where(['id_pendaftaran' => $id])
        ->with('program_les', 'murid')->get()->first();

        $program_les->tgl_indo = $this->tanggal($program_les->tanggal_pendaftaran);
        
        Header('Content-type: appliaction/json');
        echo json_encode($program_les);
    }

    public function daftarProgram()
    {
        $data['title'] = "Program Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['program_les'] = \App\Program_Les::all();
        return view('murid.daftar_program_les', $data);
    }

    public function daftar(Request $request)
    {
        if($request->program == ''){
            $request->program = null;
        }
        $request->validate([
            'program' => 'required',
            'waktuMulai' => 'required'
        ], [
            'program.required' => 'Program Les tidak boleh kosong',
            'waktuMulai.required'  => 'Tanggal Mulai tidak boleh kosong'
        ]);

        \App\Pendaftaran::insert([
            'username' => session('username'),
            'id_program_les' => $request->program,
            'status_pendaftaran' => 0,
            'tanggal_mulai' => $request->waktuMulai,
            'tanggal_pendaftaran' => date('Y-m-d'),
            'waktu_pendaftaran' => date('h:i:s'),
        ]);
        date_default_timezone_set("Asia/Jakarta");

        $data_daftar = \App\Pendaftaran::where(['pendaftaran.username' => session('username'), 'pendaftaran.id_program_les' => $request->program,'pendaftaran.tanggal_mulai' => $request->waktuMulai, 'status_pendaftaran' => 0])->get()->first();
        
        return redirect('/murid/pembayaran/' . $data_daftar->id_pendaftaran)->with('status', 'Pendaftaran berhasil, silahkan melakukan pembayaran');
        // $status = Murid::daftar($request);
        // if ($data_daftar) {
        // }
    }

    public function pembayaran($id)
    {
        $data['title'] = "Program Les";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['data_pendaftaran'] = \App\Pendaftaran::where(['id_pendaftaran' => $id])->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
            ->with('murid')
            ->get()->first();
        $data['tanggal_pendaftaran'] = $this->tanggal($data['data_pendaftaran']->tanggal_pendaftaran);
        return view('murid.pembayaran', $data);
    }

    public function bayar(Request $request, $id)
    {
        $file = $request->file('buktiDaftar');
        if($file == null){
            return redirect('/murid/pembayaran/'.$id)->with('error', 'Bukti pembayaran tidak boleh kosong');
        }
        else{
            $tujuan_upload = public_path('bukti_pembayaran/');
            $file->move($tujuan_upload, $file->getClientOriginalName());
            $nama_file = $file->getClientOriginalName();

            \App\Pendaftaran::where('id_pendaftaran', $id)
            ->update([
                'bukti_pendaftaran' => $nama_file,
                'status_pendaftaran' => 2
            ]);

            return redirect('/murid/programLes')->with('status', 'Pembayaran berhasil dilakukan, silahkan menunggu konfirmasi sekitar 1 hari (Waktu Kerja)');
        }
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
        $jumlah_pertemuan = \App\Pertemuan::select('id_kelas', DB::raw('count(id_pertemuan) as jumlah_pertemuan'))
        ->where('id_kelas', 1)
        ->groupBy('id_kelas')->get();

        $data['kelas_berjalan'] = \App\Pendaftaran::where(['pendaftaran.username' => session('username')])
        ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
        ->join('peserta_kelas', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
        ->join('kelas', 'peserta_kelas.id_kelas', '=', 'kelas.id_kelas')
        ->where('pendaftaran.status_pendaftaran', 1)
        ->get();

        for ($i=0; $i < count($data['kelas_berjalan']); $i++) { 
            // array_push($data['kelas_berjalan'][0]->peserta_kelas, "AA");
            $data['kelas_berjalan'][$i]->peserta = \App\Peserta_Kelas::where(['username' => session('username')])
            ->where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
            ->get();

            $data['kelas_berjalan'][$i]->pertemuan = \App\Pertemuan::where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)->get();

            $data['kelas_berjalan'][$i]->jadwal = \App\Jadwal_Kelas::where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
            ->with('hari', 'sesi')
            ->get();
        }
        
        return view('murid.pembelajaran', $data);
    }

    public function detailPembelajaran($id)
    {
        $data['title'] = "Pembelajaran";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['detail_kelas'] = \App\Pendaftaran::where(['pendaftaran.username' => session('username')])
        ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
        ->join('peserta_kelas', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
        ->join('kelas', 'peserta_kelas.id_kelas', '=', 'kelas.id_kelas')
        ->where('pendaftaran.status_pendaftaran', 1)
        ->where('kelas.id_kelas', intval($id))
        ->get()->first();

            $data['detail_kelas']->pertemuan = \App\Pertemuan::where('pertemuan.id_kelas', "=", $data['detail_kelas']->id_kelas)
            ->get();

            for ($i=0; $i < count($data['detail_kelas']->pertemuan); $i++) {
                $data['detail_kelas']->pertemuan[$i]->tgl_indo = $this->tanggal($data['detail_kelas']->pertemuan[$i]->tanggal);
                $data['detail_kelas']->pertemuan[$i]->kehadiran = \App\Kehadiran_Peserta::where(['id_peserta' => $data['detail_kelas']->id_peserta_kelas, 'id_pertemuan' => $data['detail_kelas']->pertemuan[$i]->id_pertemuan])->get()->first();

            }

        return view('murid.detail_pembelajaran', $data);
    }

    public function tambahFeedback(Request $request)
    {
        \App\Kehadiran_Peserta::where('id_kehadiran', intval($request->id_kehadiran))
        ->update(['feedback' => $request->feedback]);
        
        return redirect('/murid/pembelajaran/'.$request->id_kelas)->with('status', 'Feedback berhasil ditambahkan');
    }

    public function getJadwal(){
        $data['kelas_berjalan'] = \App\Pendaftaran::where(['pendaftaran.username' => session('username')])
        ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
        ->join('peserta_kelas', 'peserta_kelas.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
        ->join('kelas', 'peserta_kelas.id_kelas', '=', 'kelas.id_kelas')
        ->where('pendaftaran.status_pendaftaran', 1)
        ->get();

        for ($i=0; $i < count($data['kelas_berjalan']); $i++) { 
            // array_push($data['kelas_berjalan'][0]->peserta_kelas, "AA");
            $data['kelas_berjalan'][$i]->peserta = \App\Peserta_Kelas::where(['username' => session('username')])
            ->where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
            ->get();

            $data['kelas_berjalan'][$i]->pertemuan = \App\Pertemuan::where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
            ->get();

            $data['kelas_berjalan'][$i]->jadwal = \App\Jadwal_Kelas::where('id_kelas', "=", $data['kelas_berjalan'][$i]->id_kelas)
            ->with('hari', 'sesi')
            ->get();

            for ($j=0; $j < count($data['kelas_berjalan'][$i]->jadwal); $j++) { 
                $date1 = new DateTime(date('Y-m-d') . 'T' . $data['kelas_berjalan'][$i]->jadwal[$j]['sesi']->jam_mulai);
                $date2 = new DateTime(date('Y-m-d') . 'T' . $data['kelas_berjalan'][$i]->jadwal[$j]['sesi']->jam_selesai);
                $diff = $date2->diff($date1);
                $data['kelas_berjalan'][$i]->jadwal[$j]->durasi = $diff->format('%H:%I:%S');

                if($data['kelas_berjalan'][$i]->jadwal[$j]['hari']->id_hari == 1){
                    $data['kelas_berjalan'][$i]->jadwal[$j]['hari']->day = "MO";
                }
                elseif($data['kelas_berjalan'][$i]->jadwal[$j]['hari']->id_hari == 2){
                    $data['kelas_berjalan'][$i]->jadwal[$j]['hari']->day = "TU";
                }
                elseif($data['kelas_berjalan'][$i]->jadwal[$j]['hari']->id_hari == 3){
                    $data['kelas_berjalan'][$i]->jadwal[$j]['hari']->day = "WE";
                }
                elseif($data['kelas_berjalan'][$i]->jadwal[$j]['hari']->id_hari == 4){
                    $data['kelas_berjalan'][$i]->jadwal[$j]['hari']->day = "TH";
                }
                elseif($data['kelas_berjalan'][$i]->jadwal[$j]['hari']->id_hari == 5){
                    $data['kelas_berjalan'][$i]->jadwal[$j]['hari']->day = "FR";
                }
                elseif($data['kelas_berjalan'][$i]->jadwal[$j]['hari']->id_hari == 6){
                    $data['kelas_berjalan'][$i]->jadwal[$j]['hari']->day = "SA";
                }
                else{
                    $data['kelas_berjalan'][$i]->jadwal[$j]['hari']->day = "SU";
                }
            }

        }

        Header('Content-type: application/json');
        echo json_encode($data);
    }

    

    public function editProfil(Request $request)
    {
        //
        // $request->validate([
        //     'email' => 'required',
        //     'no_telp' => 'required',
        //     'asal_sekolah' => 'required',
        //     'alamat' => 'required',
        // ], [
        //     'email.required' => 'Email tidak boleh kosong',
        //     'no_telp.required'  => 'Nomor Telepon tidak boleh kosong',
        //     'asal_sekolah.required' => 'Asal Sekolah tidak boleh kosong',
        //     'alamat.required' => 'Alamat tidak boleh kosong'
        // ]);

        if ($request->email == null || $request->no_telp == null || $request->asal_sekolah == null || $request->alamat == null) {
            return redirect('/murid/profil')->with('gagal', 'Profil gagal diperbarui, Tidak boleh ada data yang kosong');
        } else {
            $file = $request->file('fotoProfil');
            
            if($file != null){
                $tujuan_upload = public_path('image/profil/');
                
                $file->move($tujuan_upload, $file->getClientOriginalName());
                $nama_file = 'image/profil/'.$file->getClientOriginalName();
                session(['image_profil' => $nama_file]);
                \App\User::where('username', $request->username)
                    ->update(['image' => $nama_file]);
            }
    
            \App\Murid::where('username', $request->username)
                    ->update([
                        'email' => $request->email,
                        'no_hp' => $request->no_telp,
                        'asal_sekolah' => $request->asal_sekolah,
                        'alamat' => $request->alamat
                    ]);

            return redirect('/murid/profil')->with('status', 'Data berhasil diperbarui');
        }
    }

    public function getFeedbackKelas($id){
        $data = \App\Kehadiran_Peserta::where(['id_kehadiran' => intval($id)])
        ->with('pertemuan')
        ->get()->first();

        Header('Content-type: application/json');
        echo json_encode($data);
    }
}
