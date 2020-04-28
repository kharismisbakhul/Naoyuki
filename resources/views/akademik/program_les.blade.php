@extends('layout.layout')

@section('title', 'Program Les')

@section('container')
<div class="row">
  <div class="col-lg-12">
    @if (session('status'))
      <div class="alert alert-success text-center mb-2">{{ session('status') }}</div>
      @elseif (session('gagal'))
      <div class="alert alert-danger text-center mb-2">{{ session('gagal') }}</div>
      @endif
  </div>
  <div class="col-lg-12 col-md-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 bg-danger">
        <h6 class="m-0 font-weight-bold text-capitalize text-white">Daftar Semua Program Les</h6>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="table-responsive">
            <table class="table table-striped text-wrap" id="table-daftar-program">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Foto Program</th>
                        <th>Nama Program</th>
                        <th>Jumlah Pertemuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($program_les as $pl) 
                  <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td><img src="{{ URL::asset($pl->image) }}" class="img-fluid img-profile" alt="{{ $pl->nama_program_les }}" style="width: 100px; height:100px;"></td>
                    <td>{{ $pl->nama_program_les }}</td>
                    <td>{{ $pl->jumlah_pertemuan }} Kali</td>
                    <td><a href="{{ url('/akademik/detailProgramLes/'.$pl->id_program_les) }}" class="btn btn-primary" >Detail</a></td>
                  </tr>
                  @endforeach 
                </tbody>
            </table>
        </div>
        </div>

      </div>
    </div>
  </div>

  <div class="col-lg-12 col-md-12 mb-4">
    <div class="row">
      <div class="col-lg">
          <a href="{{ url('/akademik/tambahProgram') }}" class="btn btn-danger p-5 float-right"><i class="fas fa-plus"></i><span>Tambah Program</span></a>
      </div>
    </div>
  </div>
</div>



@endsection                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 