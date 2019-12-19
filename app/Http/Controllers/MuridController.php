<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MuridController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $header = "Murid";
        return view('murid.dashboard', compact('header'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // $student = new Student;

        // $student->nama = $request->nama;
        // $student->nrp = $request->nrp;
        // $student->email = $request->email;
        // $student->jurusan = $request->jurusan;

        // $student->save();

        // Student::create([
        //     'nama' => $request->nama,
        //     'nrp' => $request->nrp,
        //     'email' => $request->email,
        //     'jurusan' => $request->jurusan
        // ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
        // return view('student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
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

        // Student::where('id', $student->id)
        //     ->update([
        //         'nama' => $request->nama,
        //         'nrp' => $request->nrp,
        //         'email' => $request->email,
        //         'jurusan' => $request->jurusan
        //     ]);
        // return redirect('/students')->with('status', 'Data berhasil dihapus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
        // Student::destroy($student->id);
        // return redirect('/students')->with('status', 'Data berhasil dihapus');
    }
}
