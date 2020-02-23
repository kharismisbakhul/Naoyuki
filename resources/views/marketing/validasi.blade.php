@extends('layout.layout')

@section('title', 'Validasi')

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
          <h6 class="m-0 font-weight-bold text-capitalize text-white">Daftar Validasi</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="table-responsive">
              <table class="table table-striped text-wrap" id="table-daftar-validasi">
                  <thead>
                      <tr class="text-center">
                          <th>No</th>
                          <th>Nama Pendaftar</th>
                          <th>Tanggal Daftar</th>
                          <th>Nama Program</th>
                          <th>Status Validasi</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($data_pendaftaran as $dp) 
                    <tr class="text-center">
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $dp->nama_lengkap }}</td>
                      <td>{{ $dp->tanggal_pendaftaran }}</td>
                      <td>{{ $dp->nama_program_les }}</td>
                      @if($dp->status_pendaftaran == 1)
                      <td class="text-success">Valid</td>
                      <td></td>
                      @elseif($dp->status_pendaftaran == 0)
                      <td class="text-warning">Belum Membayar</td>
                      <td></td>
                      @else
                      <td class="text-danger">Belum Valid</td>
                      <td><button class="btn btn-success detailValidasi" data-toggle="modal" data-target=".modalDetailValidasi" data-id="{{ $dp->id_pendaftaran }}">Validasi</button></td>
                      @endif
                      
                    </tr>
                    @endforeach 
                  </tbody>
              </table>
          </div>
        </div>
  
        </div>
      </div>
    </div>
  </div>



  <div class="modal fade modalDetailValidasi" id="ModalDetailValidasi" tabindex="-1" role="dialog" aria-labelledby="ModalDetailValidasiTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="ModalDetailValidasiTitle">Validasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <form action="{{ url('/marketing/validasi')}}" method="post">
                            @csrf
                            <input type="hidden" name="id_validasi" id="id_validasi" value="">
                            <div class="form-group">
                                <label for="validasi">Status Validasi</label>
                                <select class="form-control" id="validasi" name="validasi">
                                <option value="1">Valid</option>
                                <option value="3">Tolak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <p class="text text-success" id="bukti-pendaftaran">Bukti Pendaftaran / Transfer</p>
                                <img src="" class="bukti-les" style="width: 200px; height: 200px;"></img>
                            </div>
                            <div class="row">
                                <div class="col-lg">
                                    <button type="submit" class="btn btn-danger float-right">Validasi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection