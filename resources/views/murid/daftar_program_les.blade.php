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
        <form action="{{ url('/murid/daftarProgram') }}" method="post">
            @csrf
            <div class="form-group row">
              <label for="nama" class="col-sm-3 col-form-label">Nama</label>
              <div class="col-sm-9">
                <input type="text" readonly class="form-control" id="nama" name="nama" value="{{ session('username') }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-3 col-form-label">Program Les</label>
              <div class="col-sm-9">
                <select name="program" id="program" class="form-control">
                <option value="" selected hidden>Pilih Program Les</option>
                @foreach ($program_les as $pl)
                    <option value="{{ $pl->id_program_les }}">{{ $pl->nama_program_les }}</option>
                @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="waktuMulai" class="col-sm-3 col-form-label">Tanggal Mulai</label>
              <div class="col-sm-9">
                <input type="date" class="form-control @error('waktuMulai') is-invalid @enderror" id="waktuMulai" name="waktuMulai">
                @error('waktuMulai')
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