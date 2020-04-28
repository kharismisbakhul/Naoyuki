<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class FinanceController extends Controller
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

    public function notif(){
        $data['notif'] = \App\Pendaftaran::where('pendaftaran.status_pendaftaran', 2)
        ->join('murid', 'pendaftaran.username', '=', 'murid.username')
        ->join('program_les', 'program_les.id_program_les', '=', 'pendaftaran.id_program_les')
        ->orderBy('pendaftaran.tanggal_pendaftaran', 'asc')
        ->orderBy('pendaftaran.waktu_pendaftaran', 'asc')
        ->get();

        for ($i=0; $i < count($data['notif']); $i++) { 
            $data['notif'][$i]->tgl_indo = $this->tanggal($data['notif'][$i]->tanggal_pendaftaran);
        }
        
        $data['count_notif'] = count($data['notif']);
        return $data;
    }

    public function index()
    {
        $data['title'] = "Dashboard";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['notifikasi'] = $this->notif();
        $data['jumlah_total_pendaftar'] = \App\Pendaftaran::all()->count();
        $data['jumlah_belum_valid'] = \App\Pendaftaran::where('status_pendaftaran', 2)->get()->count();
        return view('finance.dashboard', $data);
    }

    public function validasi()
    {
        $data['title'] = "Validasi";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['notifikasi'] = $this->notif();
        $data['data_pendaftaran'] = \App\Pendaftaran::join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
            ->join('murid', 'pendaftaran.username', '=', 'murid.username')
            ->orderBy('pendaftaran.status_pendaftaran', 'asc')
            ->orderBy('pendaftaran.tanggal_pendaftaran', 'asc')
            ->get();
        
            for ($i=0; $i < count($data['data_pendaftaran']) ; $i++) { 
                $data['data_pendaftaran'][$i]->tanggal_indo = $this->tanggal($data['data_pendaftaran'][$i]->tanggal_pendaftaran);
            }

        return view('finance.validasi', $data);
    }

    public function validasi_pendaftaran(Request $request)
    {

        \App\Pendaftaran::where('id_pendaftaran', $request->id_validasi)
        ->update([
            'status_pendaftaran' => intval($request->validasi)
        ]);
        return redirect('/finance/validasi')->with('status', 'Validasi berhasil');

        // $status = DB::update('update pendaftaran set status_pendaftaran = ? where id_pendaftaran = ?', [intval($request->validasi), $request->id_validasi]);

        // if ($status == true) {
        //     return redirect('/finance/validasi')->with('status', 'Validasi berhasil');
        // } else {
        //     return redirect('/finance/validasi')->with('status', 'Validasi gagal');
        // }
    }
}
