<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SenseiController extends Controller
{
    public function index()
    {
        $data['title'] = "Dashboard";
        $data['header'] = "Sensei";
        return view('sensei.dashboard', $data);
    }
}
