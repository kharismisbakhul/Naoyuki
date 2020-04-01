<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'AuthController@login');
Route::get('/landing', 'AuthController@landing');
Route::get('/profil', 'AuthController@profil');
Route::post('/auth', 'AuthController@auth');
Route::get('/logout', 'AuthController@logout');
Route::get('/getProgram/{id}', 'AuthController@getProgramLes');

// Murid
Route::get('/murid', 'MuridController@index');
Route::get('/murid/jadwal', 'MuridController@jadwalLes');
Route::get('/murid/jadwalKosong', 'MuridController@jadwalKosong');
Route::post('/murid/jadwalKosong', 'MuridController@tambahJadwalKosong');
Route::get('/murid/programLes', 'MuridController@programLes');
Route::get('/murid/daftarProgram', 'MuridController@daftarProgram');
Route::post('/murid/daftarProgram', 'MuridController@daftar');
Route::get('/murid/pembayaran/{id}', 'MuridController@pembayaran');
Route::get('/murid/getProgramTerdaftar/{id}', 'MuridController@getProgramTerdaftar');
Route::post('/murid/bayar/{id}', 'MuridController@bayar');
Route::get('/murid/profil', 'MuridController@profil');
Route::post('/murid/editProfil', 'MuridController@editProfil');
Route::get('/murid/pembelajaran', 'MuridController@pembelajaran');
Route::get('/murid/pembelajaran/{id}', 'MuridController@detailPembelajaran');
Route::post('/murid/feedback/', 'MuridController@tambahFeedback');
Route::get('/murid/getFeedbackKelas/{id}', 'MuridController@getFeedbackKelas');

// Sensei
Route::get('/sensei', 'SenseiController@index');
Route::get('/sensei/scoreboard', 'SenseiController@scoreboard');
Route::get('/sensei/pembelajaran', 'SenseiController@pembelajaran');
Route::get('/sensei/pembelajaran/{id}', 'SenseiController@detailPembelajaran');
Route::get('/sensei/getMurid/{username}', 'SenseiController@getMurid');
Route::get('/sensei/getDetailPeserta/{id}', 'SenseiController@getDetailPeserta');
Route::get('/sensei/getKehadiranPeserta/{id}', 'SenseiController@getKehadiranPeserta');
Route::get('/sensei/tambahLaporan/{id}', 'SenseiController@tambahLaporan');
Route::post('/sensei/tambahLaporan/{id}', 'SenseiController@tambahLaporanKelas');
Route::post('/sensei/editNilaiMurid', 'SenseiController@editNilai');

// Akademik
Route::get('/akademik', 'AkademikController@index');
Route::get('/akademik/programLes', 'AkademikController@programLes');
Route::get('/akademik/detailProgramLes/{id}', 'AkademikController@detailProgramLes');
Route::get('/akademik/tambahProgram', 'AkademikController@tambahProgram');
Route::post('/akademik/tambahProgram', 'AkademikController@tambahProgramLes');
Route::get('/akademik/tambahKelas/{id}', 'AkademikController@tambahKelas');
Route::post('/akademik/tambahKelas', 'AkademikController@tambahKelasLes');

// Marketing
Route::get('/marketing', 'MarketingController@index');
Route::get('/marketing/validasi', 'MarketingController@validasi');
Route::post('/marketing/validasi', 'MarketingController@validasi_pendaftaran');

// Admin
Route::get('/admin', 'AdminController@index');

// Route::get('/about', 'PagesController@about');
// Route::get('/mahasiswa', 'MahasiswaController@index');

// Students
// Route::get('/students', 'StudentsController@index');
// Route::get('/students/create', 'StudentsController@create');
// Route::get('/students/{student}', 'StudentsController@show');

// Route::post('/students', 'StudentsController@store');
// Route::delete('/students/{student}', 'StudentsController@destroy');
// Route::get('/students/{student}/edit', 'StudentsController@edit');
// Route::patch('/students/{student}', 'StudentsController@update');

// Route::resource('students', 'StudentsController');

// Route::get('/home', 'HomeController@index')->name('home');
