@extends('layout.layout')

@section('title', 'Program Les')

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
        <h6 class="m-0 font-weight-bold text-capitalize text-white">Jadwal Kosong</h6>
      </div>
      <div class="card-body">
        <div class="row mb-3">
            <div class="col-lg-12">
              <button class="float-right btn btn-primary jadwalKosong" data-toggle="modal" data-target=".modalJadwalKosong">
                Tambah Jadwal kosong
              </button>
            </div>
          </div>
        <div class="row">
          <div class="table-responsive">
            <table class="table table-striped text-wrap" id="">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Hari</th>
                        <th>Jam</th>
                    </tr>
                </thead>
                <tbody>
                  <tr class="text-center">
                    <td>1</td>
                    <td>Senin</td>
                    <td>07.00 - 09.00</td>
                </tr>
                </tbody>
            </table>
        </div>
        </div>
      </div>
    </div>
  </div>

</div>

<div class="modal fade modalJadwalKosong" id="ModalJadwalKosong" tabindex="-1" role="dialog" aria-labelledby="ModalJadwalKosongTitle" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title text-danger" id="ModalJadwalKosongTitle">Tambah Jadwal Kosong</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="row justify-content-center">
                  <div class="col-lg-12">
                      <form action="{{ url('/murid/jadwalKosong/')}}" method="post">
                          @csrf
                          <input type="hidden" name="username" value="">
                          <div class="form-group">
                              <label for="hari">Hari</label>
                              <select class="form-control" id="hari" name="hari">
                                <option value="" hidden selected>Pilih Hari</option>
                                <option value="">Senin</option>
                                <option value="">Selasa</option>
                                <option value="">Rabu</option>
                                <option value="">Kamis</option>
                                <option value="">Jumat</option>
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="Jam">Jam</label>
                              <input type="time" class="form-control" id="jam" name="jam">
                          </div>
                          <div class="row">
                              <div class="col-lg">
                                  <button type="submit" class="btn btn-danger float-right">Tambah Jadwal Kosong</button>
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