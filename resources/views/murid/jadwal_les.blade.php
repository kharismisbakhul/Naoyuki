@extends('layout.layout')

@section('title', 'Jadwal Les')

@section('container')

  <div class="row">
    
    <div class="col-lg-12 col-md-12 mb-4">
      <div class="card shadow mb-4">
        <div class="card-header py-3 bg-danger">
          <h6 class="m-0 font-weight-bold text-capitalize text-white">Jadwal Les</h6>
        </div>
        <div class="card-body">

            <div class="row">
              <div class="col-lg-12">
                <a href="{{ url('/murid/jadwalKosong') }}" class="float-right btn btn-primary">
                  Jadwal kosong
                </a>
              </div>
            </div>
          
            <!-- Start Calendar -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                  <div class="row mt-2 mb-1 m-0">
                      <h2 class="col-lg-6 monthYear">
                      </h2>
                  </div>
                  <div class="row mb-4 m-0">
                      <div class="form-group col-lg-3">
                          <input class="form-control" type="date" name="calendarSpesifik" id="tanggalSpesifik">
                      </div>
                  </div>
                  <div class="row m-0 col-lg-12">
                      <div id="calendar" style="margin: 0 auto;"></div>
                  </div>
                </div>
            </div>
            <!-- End Calendar -->
          
        </div>
      </div>
    </div>

  </div>

@endsection                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 