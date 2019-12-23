@extends('layout.layout')

@section('title', 'Program Les')

@section('container')
<div class="row">
  <div class="col-lg-12">
    @if (session('status'))
    <div class="alert alert-success text-center mb-2">{{ session('status') }}</div>
    @endif
  </div>

    <div class="col-xl-6 col-md-6 col-lg-4 mb-4 dftr">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger mb-1">
                {{ $program_les->nama_program_les }}</div>
              <div class="h4 mb-0 font-weight-bold text-gray-800 mt-3"><span></span> {{ $program_les->jumlah_pertemuan }} Pertemuan
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-4x text-danger"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-xl-6 col-md-6 col-lg-4 mb-4 dftr">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger mb-1">
                Materi</div>
              <div class="h4 mb-0 font-weight-bold text-gray-800 mt-3"><span></span> {{ $program_les->cakupan_materi }}
              </div>
              <div class="h4 mb-0 font-weight-bold text-gray-800 mt-3"><a href="#" class="btn btn-danger">Tambah Materi</a>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-4x text-danger"></i>
            </div>
          </div>
        </div>
      </div>
    </div>


  <div class="col-lg-12 col-md-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 bg-danger">
        <h6 class="m-0 font-weight-bold text-capitalize text-white">Daftar Kelas</h6>
      </div>
      <div class="card-body">
          <div class="row">
              <div class="col-lg-12">
                <a href="{{ url('/akademik/tambahKelas/'.$program_les->id_program_les ) }}" class="btn btn-danger float-right">Tambah Kelas</a>
              </div>
          </div>
        <div class="row">
          <div class="table-responsive">
            <table class="table table-striped text-wrap" id="table-daftar-program">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Sensei</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($kelas as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $k->nama_kelas }}</td>
                            <td>{{ $k->nama_sensei }}</td>
                            <td><button class="btn btn-primary">Detail</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
      
        {{-- <div class="row justify-content-center text-center mt-2"> --}}
                      
         
        
        {{-- <div class="card col-lg-3 mx-2 my-2" style="width: 18rem;">
          <img src="{{ URL::asset($pl->image) }}" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">{{ $pl->nama_program_les }}</h5>
            <a href="#" class="card-text float-right mt-5"><small class="text-danger">Detail</small></a>
          </div>
        </div> --}}

        {{-- <div class="card mb-3" style="max-width: 350px;">
          <div class="row no-gutters">
            <div class="col-md-4">
              <img src="{{ URL::asset($pl->image) }}" class="card-img" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">{{ $pl->nama_program_les }}</h5>
                <a href="#" class="card-text float-right"><small class="text-danger">Detail</small></a>
              </div>
            </div>
          </div>
        </div> --}}
        
        
      {{-- </div> --}}


      </div>
    </div>
  </div>
</div>




@endsection                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 