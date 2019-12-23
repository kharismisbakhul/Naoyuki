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
        <form action="{{ url('/akademik/tambahProgram') }}" method="post">
            @csrf
            <div class="form-group row">
              <label for="nama" class="col-sm-3 col-form-label">Nama Program</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nama" name="nama" value="">
              </div>
            </div>
            <div class="form-group row">
              <label for="jumlah_pertemuan" class="col-sm-3 col-form-label">Jumlah Pertemuan</label>
              <div class="col-sm-9">
                <input type="number" class="form-control" id="jumlah_pertemuan" name="jumlah_pertemuan" value="{{ session('username') }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="biaya" class="col-sm-3 col-form-label">Biaya</label>
              <div class="col-sm-9">
                <input type="number" class="form-control" id="biaya" name="biaya" value="{{ session('username') }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="materi" class="col-sm-3 col-form-label">Cakupan Materi</label>
              <div class="col-sm-9">
                <textarea name="materi" class="form-control" id="materi" rows="5"></textarea>
                {{-- <input type="text" readonly class="form-control" id="materi" name="materi" value="{{ session('username') }}"> --}}
              </div>
            </div>
            <div class="form-group row">
              <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
              <div class="col-sm-9">
                <textarea name="deskripsi" class="form-control" id="deskripsi" rows="5"></textarea>
                {{-- <input type="text" readonly class="form-control" id="deskripsi" name="deskripsi" value="{{ session('username') }}"> --}}
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