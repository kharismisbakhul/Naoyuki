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
              <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="">
            </div>
          </div>
          <div class="form-group row murid-murid">
            <label for="murid[]" class="col-sm-3 col-form-label">Nama Murid</label>
            <div class="col-sm-8">
              <select class="form-control" id="muridA" name="murid[]">
                      <option value="" hidden selected>Pilih Murid</option>
                      @foreach ($murid as $m)
                      <option value="{{ $m->id_pendaftaran }}">{{ $m->nama_lengkap }}</option>
                      @endforeach
                  </select>
            </div>
            <a href="#" class="btn btn-danger col-sm-1 tambah-murid"><i class="fas fa-fw fa-plus text-white" id="icon-murid"></i></a>
          </div>
          
          {{--  <div class="form-group row murid-baru">
            
          </div>  --}}


          <div class="form-group row waktu-pertemuan">
            <label for="hariPertemuan1" class="col-sm-3 col-form-label">Waktu Pertemuan 1</label>
            <div class="col-sm-5">
              <select class="form-control" id="hariPertemuan1" name="hariPertemuan1">
                    <option value="" hidden selected>Pilih Hari</option>
                    {{--  @foreach ($hari as $h)
                    <option value="{{$h->id_hari}}">{{$h->hari}}</option>
                    @endforeach  --}}
                  </select>
            </div>
            <div class="col-sm-4">
              <select class="form-control" id="waktuPertemuan1" name="waktuPertemuan1">
                        <option value="" hidden selected>Pilih Sesi</option>
                        {{--  @foreach ($sesi as $s)
                        <option value="{{$s->id_sesi}}">{{$s->jam_mulai. ' - '.$s->jam_selesai}}</option>
                        @endforeach  --}}
                    </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="hariPertemuan2" class="col-sm-3 col-form-label">Waktu Pertemuan 2</label>
            <div class="col-sm-5">
              <select class="form-control" id="hariPertemuan2" name="hariPertemuan2">
                    <option value="" hidden selected>Pilih Hari</option>
                    {{--  @foreach ($hari as $h)
                    <option value="{{$h->id_hari}}">{{$h->hari}}</option>
                    @endforeach  --}}
                  </select>
            </div>
            <div class="col-sm-4">
              <select class="form-control" id="waktuPertemuan2" name="waktuPertemuan2">
                        <option value="" hidden selected>Pilih Sesi</option>
                        {{--  @foreach ($sesi as $s)
                        <option value="{{$s->id_sesi}}">{{$s->jam_mulai. ' - '.$s->jam_selesai}}</option>
                        @endforeach  --}}
                    </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="nama_sensei" class="col-sm-3 col-form-label">Nama Sensei</label>
            <div class="col-sm-9">
              <select class="form-control" id="nama_sensei" name="nama_sensei">
                      <option value="" hidden selected>Pilih Sensei</option>
                        {{--  @foreach ($sensei as $s)
                        <option value="{{ $s->id_sensei }}">{{ $s->nama_sensei }}</option>
                        @endforeach  --}}
                    </select>
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