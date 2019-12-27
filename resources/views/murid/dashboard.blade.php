@extends('layout.layout')

@section('title', 'Dashboard Murid')

@section('container')

  <div class="row">
    <div class="col-lg-12 col-md-12 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col ml-auto">
              <div class="h5 mb-0 font-weight-bold text-gray-800">Selamat Datang, <span id="user_name" class="text-gray-900 font-weight-bolder">Kharis</span></div>
              <div class="text-s font-weight-normal text-gray-800 mt-2"></div>
            </div>
            <div class="col-auto mr-3">
              <i class="far fa-grin-beam fa-3x"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="row">
    
    <div class="col-lg-6 col-md-12 mb-4">
      <div class="card shadow mb-4">
        <div class="card-header py-3 bg-danger">
          <h6 class="m-0 font-weight-bold text-capitalize text-white">Program Les Berjalan</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">

            {{-- Start Program --}}
            @foreach ($program_berjalan as $pb)
            @if($pb->status_pendaftaran == 1)
            <div class="card mb-3 col-lg">
              <div class="row no-gutters">
                <div class="col-md-4">
                  <img src="{{ URL::asset($pb->image) }}" class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title mb-5">{{$pb->nama_program_les}}</h5>
                    <a href="{{ url('/murid/pembelajaran/1') }}" class="card-text float-right mt-5"><small class="text-danger">Detail</small></a>
                  </div>
                </div>
              </div>
            </div>
            @endif
            @endforeach
            {{-- End Program --}}
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-12 mb-4">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
      <div class="card shadow mb-4">
        <div class="card-header py-3 bg-danger">
          <h6 class="m-0 font-weight-bold text-capitalize text-white">Jumlah Pertemuan</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover text-left text-nowrap " id="dataTable" width="100%" cellspacing="0">
              <thead style="background-color: #2980b9;color:#ecf0f1 ">
                <tr>
                  <th>No</th>
                  <th>Nama Kelas</th>
                  <th>Program</th>
                  <th>Pertemuan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Sakura</td>
                  <td>Kana</td>
                  <td>10 / 20</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 