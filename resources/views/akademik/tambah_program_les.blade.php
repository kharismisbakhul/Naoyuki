@extends('layout.layout')

@section('title', 'Program Les')

@section('container')
<div class="row">
    
  <div class="col-lg-12 col-md-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 bg-danger">
        <h6 class="m-0 font-weight-bold text-capitalize text-white">Formulir Pendaftaran Program Les</h6>
      </div>
      <div class="card-body">
        <form action="{{ url('/akademik/tambahProgram') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
              <label for="nama" class="col-sm-3 col-form-label">Nama Program</label>
              <div class="col-sm-9">
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="">
                @error('nama')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="jumlah_pertemuan" class="col-sm-3 col-form-label">Jumlah Pertemuan</label>
              <div class="col-sm-9">
                <input type="number" class="form-control @error('jumlah_pertemuan') is-invalid @enderror" id="jumlah_pertemuan" name="jumlah_pertemuan" value="{{ session('username') }}">
                @error('jumlah_pertemuan')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="biaya" class="col-sm-3 col-form-label">Biaya</label>
              <div class="col-sm-9">
                <input type="number" class="form-control @error('biaya') is-invalid @enderror" id="biaya" name="biaya" value="{{ session('username') }}">
                @error('biaya')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="materi" class="col-sm-3 col-form-label">Cakupan Materi</label>
              <div class="col-sm-9">
                <textarea name="materi" class="form-control @error('materi') is-invalid @enderror" id="materi" rows="5"></textarea>
                @error('materi')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
              <div class="col-sm-9">
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" rows="5"></textarea>
                @error('deskripsi')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="foto_program" class="col-sm-3 col-form-label">Foto Program</label>
              <div class="col-sm-9">
                  <input type="file" name="fotoProgram" class="@error('fotoProgram') is-invalid @enderror" id="fotoProgram">
                  @error('fotoProgram')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
              </div>
            </div>
            <div class="row">
                <div class="col-lg">
                    <button type="submit" class="btn btn-danger float-right">Daftar</button>
                </div>
            </div>
          </form>
      </div>
    </div>
  </div>

</div>
@endsection                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 