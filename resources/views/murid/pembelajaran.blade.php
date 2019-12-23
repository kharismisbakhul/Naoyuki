@extends('layout.layout')

@section('title', 'Pembelajaran Murid')

@section('container')
<div class="row">
    <div class="col-lg-12">
      @if (session('status'))
      <div class="alert alert-success text-center mb-2">{{ session('status') }}</div>
      @endif
    </div>
  
    <div class="col-lg-12 col-md-12 mb-4">
      <div class="card shadow mb-4">
        <div class="card-header py-3 bg-danger">
          <h6 class="m-0 font-weight-bold text-capitalize text-white">Pembelajaran Berjalan</h6>
        </div>
        <div class="card-body">
          <div class="card col-lg-5 mb-3" style="">
          <div class="row no-gutters">
            <div class="col-md-4">
                <figure class="figure text-center">
                    <img src="{{URL::asset(url('image/thumbnail.jpg'))}}" class="img-thumbnail rounded" style="width: 200px; height: 200px;">
                    <figcaption class="figure-caption mt-3">
                        <h3>Pertemuan</h3>
                        <h3>10/20</h3>
                    </figcaption>
                </figure>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h3 class="card-title">'Sakura'</h3>
                <h3 class="card-title mb-5">Basic Grammar</h3>
                <a href="#" class="card-text float-right mt-5"><small class="text-danger">Detail</small></a>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  
  </div>

@endsection                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 