<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\TestCase;

class tambahJadwalKosongTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
     public function test_case_1()
     {
          /**
          * Hari dan Jam Kosong
          */
 
         $user = \App\User::find(5);
         $response = $this->actingAs($user)->post('/murid/jadwalKosong/',
         [
             'hari' => null,
             'jam' => null
         ]);
         $response->assertJson([
             'status' => 'error',
             'message' => 'Hari dan Jam tidak boleh kosong',
         ]);
     }
     public function testCase2()
     {
          /**
          * Jam Kosong
          */
 
         $user = \App\User::find(5);
         $response = $this->actingAs($user)->post('/murid/jadwalKosong/',
         [
             'hari' => 1,
             'jam' => null
         ]);
         $response->assertJson([
             'status' => 'error',
             'message' => 'Jam tidak boleh kosong',
         ]);
     }
     public function testCase3()
     {
          /**
          * Hari Kosong
          */
 
         $user = \App\User::find(5);
         $response = $this->actingAs($user)->post('/murid/jadwalKosong/',
         [
             'hari' => null,
             'jam' => 1
         ]);
         $response->assertJson([
             'status' => 'error',
             'message' => 'Hari tidak boleh kosong',
         ]);
     }
     public function testCase4()
     {
          /**
          * Jadwal belum pernah dimasukkan sebelumnya
          */
 
         $user = \App\User::find(5);
         $response = $this->actingAs($user)->post('/murid/jadwalKosong/',
         [
             'hari' => 5,
             'jam' => 1
         ]);
         $response->assertJson([
             'status' => 'success',
             'message' => 'Penambahan jadwal kosong berhasil',
         ]);
     }
     public function testCase5()
     {
          /**
          * Jadwal Sudah ada dan belum terpakai kelas
          */
 
         $user = \App\User::find(5);
         $response = $this->actingAs($user)->post('/murid/jadwalKosong/',
         [
             'hari' => 2,
             'jam' => 4
         ]);
         $response->assertJson([
             'status' => 'error',
             'message' => 'Jadwal kosong sudah ada',
         ]);
     }
     public function testCase6()
     {
          /**
          * Jadwal Sudah ada dan Sudah terpakai kelas
          */
 
         $user = \App\User::find(5);
         $response = $this->actingAs($user)->post('/murid/jadwalKosong/',
         [
             'hari' => 1,
             'jam' => 1
         ]);
         $response->assertJson([
             'status' => 'error',
             'message' => 'Jadwal tidak kosong',
         ]);
     }
}
