<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SenseiController extends Controller
{
    public function index()
    {
        $header = "Sensei";
        return view('sensei.dashboard', compact('header'));
    }
}
