@extends('layout.layout')

@section('title', 'Program Les')

@section('container')
<div class="row">
  <div class="col-lg-12">
    @if (session('status'))
    <div class="alert alert-success text-center mb-2">{{ session('status') }}</div>
    @elseif (session('error'))
    <div class="alert alert-danger text-center mb-2">{{ session('error') }}</div>
    @endif
  </div>
<div class="col-lg-12 col-md-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 bg-danger">
        <h6 class="m-0 font-weight-bold text-capitalize text-white">Instruksi Pembayaran</h6>
      </div>
      <div class="card-body">
        <div class="row justify-content-left">
          <div class="col-lg-3 mr-2">
              <figure class="figure text-center">
                  <img src="{{URL::asset(url($data_pendaftaran->image))}}" class="img-thumbnail rounded" style="width: 300px; height: 300px;">
                  <figcaption class="figure-caption mt-3">
                      <h3>Program: {{ $data_pendaftaran->nama_program_les }}</h3>
                      <h5>Tanggal Pendaftaran:</h5>
                      <h5>{{ $tanggal_pendaftaran }}</h5>
                      <h5>Pukul {{ $data_pendaftaran->waktu_pendaftaran }}</h5>
                  </figcaption>
              </figure>
          </div>
          <div class="col-lg-3">
              <div class="row"><h4 class="mt-3">Data Pendaftar</h4></div><hr>
              <div class="row"><h4 class="mt-4">Nama Lengkap: {{ $data_pendaftaran['murid']->nama_lengkap }}</h4></div>
              <div class="row"><h4 class="mt-4">Email: {{ $data_pendaftaran['murid']->email }}</h4></div>
              <div class="row"><h4 class="mt-4">No. Telepon: {{ $data_pendaftaran['murid']->no_hp }}<h4></div>
              <div class="row"><h4 class="mt-4">Asal Sekolah: {{ $data_pendaftaran['murid']->asal_sekolah }}</h4></div>
              <div class="row"><h4 class="mt-4">Alamat: {{ $data_pendaftaran['murid']->alamat }}</h4></div>
          </div>
          <div class="col-lg-1"></div>
          <div class="col-lg-4 ml-0">
              <div class="row"><h4 class="mt-3">Instruksi Pembayaran</h4></div><hr>
              <div class="row"><h4 class="mt-4">Silahkan Melakukan Pembayaran senilai</h4></div>
              <div class="row"><h4 class="mt-4">Rp. {{ $data_pendaftaran->biaya }}</h4></div>
              <div class="row"><h4 class="mt-4">ke Rekening dibawah ini</h4></div>
              <div class="row"><h4 class="mt-4">BNI: 0322-32323-22 A.N. Sholihatta Aziz</h4></div>
              <div class="row"><h4 class="mt-4">BRI: 0322-32323-22 A.N. Sholihatta Aziz</h4></div>
          </div>
      </div>
        <div class="row">
            <div class="col-lg">
              <form action="{{ url('/murid/bayar/'.$data_pendaftaran->id_pendaftaran) }}" method="post" enctype="multipart/form-data">
                @csrf
                <button type="submit" class="btn btn-danger float-right">Konfirmasi</button>
                <input type="hidden" name="id_pendaftaran" value="{{ $data_pendaftaran->id_pendaftaran }}">
                <input type="file" name="buktiDaftar" class="float-right mr-5">
                <h4 class="float-right mr-3 mt-1">Upload Bukti Pembayaran</h4>
              </form>
              <a class="" href="{{ url('/murid/programLes') }}" style="text-decoration: none;">
                <button class="mr-2 d-none d-lg-inline text-gray-600 small btn btn-secondary" ><span class="text-white">Kembali</span></button>
              </a>
            </div>
        </div>
    </div>
  </div>

</div>
@endsection                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 