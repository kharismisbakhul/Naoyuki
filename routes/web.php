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

Route::get('/', 'PagesController@login');
Route::get('/landing', 'PagesController@landing');
Route::post('/auth', 'PagesController@auth');
Route::get('/logout', 'PagesController@logout');

// Murid
Route::get('/murid', 'MuridController@index');

// Sensei
Route::get('/sensei', 'SenseiController@index');

// Akademik
Route::get('/akademik', 'AkademikController@index');

// Marketing
Route::get('/marketing', 'MarketingController@index');

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

Route::resource('students', 'StudentsController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
