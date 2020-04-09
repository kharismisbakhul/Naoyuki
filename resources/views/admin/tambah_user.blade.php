@extends('layout.layout')

@section('title', 'Tambah User')

@section('container')
<div class="row">
    
  <div class="col-lg-12 col-md-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 bg-danger">
        <h6 class="m-0 font-weight-bold text-capitalize text-white">Tambah User</h6>
      </div>
      <div class="card-body">
        <form action="{{ url('/admin/tambahUser') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
              <label for="username" class="col-sm-3 col-form-label">Username</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="username" name="username" value="">
              </div>
            </div>
            <div class="form-group row">
              <label for="password" class="col-sm-3 col-form-label">Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="password" name="password">
              </div>
            </div>
            <div class="form-group row">
              <label for="status" class="col-sm-3 col-form-label">Status User</label>
              <div class="col-sm-9">
                <select type="number" class="form-control status" id="status" name="status">
                    <option value="" hidden selected>Pilih Status User</option>
                    @foreach($status_user as $su)
                    <option value="{{$su->id_status_user}}">{{$su->nama_status_user}}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row nama_lengkap">
            </div>
            <div class="form-group row no_hp">
            </div>
                <div class="form-group row email">
                </div>
            <div class="form-group row asal_sekolah">
            </div>
            <div class="form-group row alamat">
            </div>
            <div class="form-group row foto">
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