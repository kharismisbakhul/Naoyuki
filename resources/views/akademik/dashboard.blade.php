@extends('layout.layout')

@section('title', 'Dashboard Akademik')

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
  
<div class="col-xl-6 col-md-6 col-lg-4 mb-4 dftr">
  <div class="card border-left-danger shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-danger mb-1">
            Jumlah Program Les</div>
          <div class="h4 mb-0 font-weight-bold text-gray-800 mt-3"><span></span> Mahasiswa
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
            Jumlah Kelas</div>
          <div class="h4 mb-0 font-weight-bold text-gray-800 mt-3"><span></span> Kelas
          </div>
        </div>
        <div class="col-auto">
          <i class="fas fa-users fa-4x text-danger"></i>
        </div>
      </div>
    </div>
  </div>
</div>


</div>
@endsection