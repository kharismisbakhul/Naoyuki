@extends('layout.layout') @section('title', 'Pembelajaran Murid') @section('container')
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

        <div class="row">
          <input class="float-right col-lg-2 mb-3 form-control" type="text" id="cariPembelajaran" onkeyup="cariPembelajaran()" placeholder="Cari kelas pembelajaran...">
        </div>
        
        <div class="row kelasp">

          @if(count($kelas_berjalan) == 0)
          <div class="alert alert-warning text-center mb-2 col-lg-12">Tidak ada pembelajaran yang sedang berjalan</div>
          @else @foreach ($kelas_berjalan as $kb)
          <div class="card col-lg-5 mb-3 kelasPembelajaran" style="">
            <div class="row no-gutters">
              <div class="col-md-4">
                <figure class="figure text-center">
                  <img src="{{ URL::asset($kb->image) }}" class="img-thumbnail rounded" style="width: 100%; height: 100%;" alt="{{$kb->nama_kelas}}">
                  <figcaption class="figure-caption mt-3">
                    <h3>Pertemuan</h3>
                    <h3>{{count($kb->pertemuan).'/'.$kb->jumlah_pertemuan}}</h3>
                    @if($kb->status_les == 1) @if($kb->nilai_evaluasi >= 80)
                    <h3 class="text-success">Lulus</h3>
                    @else
                    <h3 class="text-danger">Tidak Lulus</h3>
                    @endif @endif
                  </figcaption>
                </figure>
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h3 class="card-title namaKelas">'{{$kb->nama_kelas}}'</h3>
                  <h3 class="card-title">{{$kb->nama_program_les}}</h3>

                  <h3 class="card-title">Jadwal :</h3>
                  @foreach($kb->jadwal as $jadwal)
                  <h3 class="card-title">{{$jadwal['hari']->hari.' '.substr($jadwal['sesi']->jam_mulai,0,5). ' - '.substr($jadwal['sesi']->jam_selesai,0,5)}}</h3>
                  @endforeach
                  <a href="{{ url('/murid/pembelajaran/'.$kb->id_kelas) }}" class="card-text float-right mt-5 mb-3 btn btn-danger"><small class="text-white">Detail</small></a>
                </div>
              </div>

            </div>
          </div>

          <div class="col-lg-1 mb-3 spasiPembelajaran" style="">
          </div>
          @endforeach @endif

        </div>
      </div>
    </div>
  </div>

</div>

@endsection