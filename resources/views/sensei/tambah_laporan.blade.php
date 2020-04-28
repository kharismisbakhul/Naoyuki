@extends('layout.layout') @section('title', 'Penambahan Laporan Pembelajaran') @section('container')
<div class="row">

  <div class="col-lg-12 col-md-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 bg-danger">
        <h6 class="m-0 font-weight-bold text-capitalize text-white">Formulir Penambahan Laporan</h6>
      </div>
      <div class="card-body">
        <form action="{{ url('/sensei/tambahLaporan/'.$detail_kelas->id_kelas) }}" method="post">
          @csrf
          <input type="hidden" name="id_kelas" value="{{$detail_kelas->id_kelas}}">
          <input type="hidden" name="jumlah_pertemuan" value="{{$detail_kelas->jumlah_pertemuan}}">
          <div class="form-group row">
            <label for="nama_program" class="col-sm-3 col-form-label">Nama Program</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="nama_program" name="nama_program" value="{{$detail_kelas->nama_program_les}}" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="nama_kelas" class="col-sm-3 col-form-label">Nama Kelas</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="{{$detail_kelas->nama_kelas}}" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="pertemuan" class="col-sm-3 col-form-label">Pertemuan Ke</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="pertemuan" name="pertemuan" value="{{$detail_kelas->jumlah_pertemuan_hadir +  1}}" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
            <div class="col-sm-9">
              <input type="date" class="form-control  @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal">
              @error('tanggal')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row">
            <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi Laporan</label>
            <div class="col-sm-9">
              <textarea name="deskripsi" class="form-control  @error('deskripsi') is-invalid @enderror" id="deskripsi" rows="5"></textarea>
              @error('deskripsi')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row">
            <label for="kehadiran" class="col-sm-3 col-form-label">Kehadiran</label>
            <table class="table table-hover text-nowrap col-sm-9" id="dataTable" width="100%" cellspacing="0" border="1">
              <thead class="text-center" style="background-color: #2980b9;color:#ecf0f1">
                <tr>
                  <th>Nama Murid</th>
                  <th>Kehadiran</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($detail_kelas->peserta as $dkp)
                <tr class="text-center">
                  <td>{{$dkp->nama_lengkap}}</td>
                  <td>
                      <input type="checkbox" name="kehadiran[]" value="{{$dkp->id_peserta_kelas}}" checked>
                      
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="row">
            <div class="col-lg">
              <button type="submit" class="btn btn-danger float-right">Tambah Laporan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection