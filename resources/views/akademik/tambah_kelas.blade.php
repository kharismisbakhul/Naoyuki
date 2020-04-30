@extends('layout.layout') @section('title', 'Program Les') @section('container')
<div class="row">

  <div class="col-lg-12 col-md-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 bg-danger">
        <h6 class="m-0 font-weight-bold text-capitalize text-white">Formulir Penambahan Kelas</h6>
      </div>
      <div class="card-body">
        <form action="{{ url('/akademik/tambahKelas') }}" class="form-kelas" method="post">
          @csrf
          <div class="form-group row">
            <label for="nama_program" class="col-sm-3 col-form-label">Nama Program</label>
            <div class="col-sm-9">
              <input type="hidden" class="form-control" id="nama_program" name="nama_program" value="{{ $program_les->id_program_les }}">
              <input type="text" class="form-control" id="nama_program_temp" name="nama_program_temp" value="{{ $program_les->nama_program_les }}"
                readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="nama_kelas" class="col-sm-3 col-form-label">Nama Kelas</label>
            <div class="col-sm-9">
              <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" id="nama_kelas" name="nama_kelas" value="">
              @error('nama_kelas')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row murid-murid">
            <input type="hidden" class="form-control" id="jumlah_murid" name="jumlah_murid" value="1">
            <label for="peserta[]" class="col-sm-3 col-form-label">Peserta Kelas</label>
            
            <div class="col-sm-9">
                @if(count($murid) == 0)
                <div class="alert alert-warning text-center mb-2 col-lg-12">Tidak ada Pendaftar Program Ini</div>
                @else
                <table class="table table-hover text-nowrap" id="rencana_peserta" width="100%" cellspacing="0" border="1">
                    <thead class="text-center" style="background-color: #2980b9;color:#ecf0f1">
                      <tr>
                        <th>Nama Murid</th>
                        <th>Peserta</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($murid as $m)
                      <tr class="text-center">
                        <td>{{$m->nama_lengkap}}</td>
                        <td>
                            <input type="checkbox" name="peserta[]" value="{{$m->id_pendaftaran}}">
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <span><p class="btn btn-danger mt-1 detail-jadwal">Detail Jadwal</p></span>
                  @endif
            </div>  
          </div>


          <div class="form-group row waktu-pertemuan">
            <label for="hariPertemuan1" class="col-sm-3 col-form-label">Waktu Pertemuan 1</label>
            <div class="col-sm-5">
              <select class="form-control @error('hariPertemuan1') is-invalid @enderror" id="hariPertemuan1" name="hariPertemuan1">
                    <option value="null" hidden selected>Pilih Hari</option>
                  </select>
                  @error('hariPertemuan1')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
            </div>
            <div class="col-sm-4">
              <select class="form-control @error('waktuPertemuan1') is-invalid @enderror" id="waktuPertemuan1" name="waktuPertemuan1">
                        <option value="null" hidden selected>Pilih Sesi</option>
                    </select>
                    @error('waktuPertemuan1')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
            </div>
          </div>
          <div class="form-group row">
            <label for="hariPertemuan2" class="col-sm-3 col-form-label">Waktu Pertemuan 2</label>
            <div class="col-sm-5">
              <select class="form-control @error('hariPertemuan2') is-invalid @enderror" id="hariPertemuan2" name="hariPertemuan2">
                    <option value="null" hidden selected>Pilih Hari</option>
                  </select>
                  @error('hariPertemuan2')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
            </div>
            <div class="col-sm-4">
              <select class="form-control @error('waktuPertemuan2') is-invalid @enderror" id="waktuPertemuan2" name="waktuPertemuan2">
                        <option value="null" hidden selected>Pilih Sesi</option>
                    </select>
                    @error('waktuPertemuan2')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
            </div>
          </div>

          <div class="form-group row">
            <label for="nama_sensei" class="col-sm-3 col-form-label">Nama Sensei</label>
            <div class="col-sm-9">
              <select class="form-control @error('nama_sensei') is-invalid @enderror" id="nama_sensei" name="nama_sensei">
                      <option value="null" hidden selected>Pilih Sensei</option>
                    </select>
                    @error('nama_sensei')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-lg">
              <button type="submit" class="btn btn-danger float-right">Tambah Kelas</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection