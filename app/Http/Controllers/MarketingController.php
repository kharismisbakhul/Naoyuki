<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class MarketingController extends Controller
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
        $data['title'] = "Dashboard Marketing";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        return view('marketing.dashboard', $data);
    }

    public function validasi()
    {
        $data['title'] = "Validasi";
        $data['tanggal'] = $this->tanggal(date('Y-m-d'));
        $data['data_pendaftaran'] = DB::table('pendaftaran')
            ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
            ->join('murid', 'pendaftaran.username', '=', 'murid.username')
            ->get();
        return view('marketing.validasi', $data);
    }
}
