@extends('layout.layout') @section('title', 'Program Les') @section('container')
<div class="row">
  <div class="col-lg-12">
    @if (session('status'))
    <div class="alert alert-success text-center mb-2">{{ session('status') }}</div>
    @endif
  </div>

  <div class="col-xl-6 col-md-6 col-lg-4 mb-4 dftr">
    <div class="card border-left-danger shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-s font-weight-bold text-danger mb-1">
              {{ $program_les->nama_program_les }}</div>
            <div class="h4 mb-0 font-weight-bold text-gray-800 mt-3"><span></span> {{ $program_les->jumlah_pertemuan }} Pertemuan
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-users fa-4x text-danger mt-4"></i>
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
            <div class="text-s font-weight-bold text-danger mb-1">
              Materi</div>
            <div class="h4 mb-0 font-weight-bold text-gray-800 mt-3"><span></span> {{ $program_les->cakupan_materi }}
            </div>
            <div class="h4 mb-0 font-weight-bold text-gray-800 mt-3"><button class="btn btn-danger editMateri" data-toggle="modal" data-target=".modalEditMateri">Edit Materi</button>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-users fa-4x text-danger"></i>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="col-lg-12 col-md-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 bg-danger">
        <h6 class="m-0 font-weight-bold text-capitalize text-white">Daftar Kelas</h6>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <a href="{{ url('/akademik/tambahKelas/'.$program_les->id_program_les ) }}" class="btn btn-danger float-right">Tambah Kelas</a>
          </div>
        </div>
        <div class="row">
          <div class="table-responsive">
            <table class="table table-striped text-wrap" id="table-daftar-kelas">
              <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th>Nama Kelas</th>
                  <th>Jadwal</th>
                  <th>Sensei</th>
                  <th>Jumlah Pertemuan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody class="text-center">
                @foreach ($kelas as $k)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $k->nama_kelas }}</td>
                  <td>
                    @foreach ($k->jadwal as $jadwal) {{ $jadwal->hari.' '.substr($jadwal->jam_mulai,0,5). ' - '.substr($jadwal->jam_selesai,0,5)}}<br>                    @endforeach
                  </td>
                  <td>{{ $k->nama_sensei }}</td>
                  <td>{{ $k->pertemuan.'/'.$k->jumlah_pertemuan}}</td>
                  <td><button class="btn btn-primary detail_kelas" data-toggle="modal" data-target=".modalDetailKelas" data-id="{{ $k->id_kelas }}">Detail</button>
                  </td>
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

{{-- Modal Detail Kelas --}}
<div class="modal fade modalDetailKelas" id="ModalDetailKelas" tabindex="-1" role="dialog" aria-labelledby="ModalDetailKelasTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="ModalDetailKehadiranTitle">Detail Kelas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12 col-md-12 mb-4">
            <div class="row">
                <div class="col-lg-12">
                    <h6 class="mb-3 float-right">Nama Kelas: <span class="font-weight-bold text-capitalize" id="nama-kelas-modal"></span></h6>
                </div>
            </div>
            
            {{-- Tabel Peserta --}}
            <h6 class="mb-3">Daftar Peserta Kelas</h6>
            <div class="row">
              <div class="table-responsive">
                <table class="table text-wrap" id="table-peserta-akademik">
                  <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>Nama Murid</th>
                      <th>Nilai Evaluasi</th>
                    </tr>
                  </thead>
                  <tbody class="text-center" id="body-peserta-modal">
                  </tbody>
                </table>
              </div>
            </div>


            {{-- Tabel Pertemuan --}}
            <h6 class="mb-3 mt-5">Detail Pertemuan</h6>
            <div class="row">
              <div class="table-responsive">
                <table class="table table-striped text-wrap" id="table-pertemuan-akademik">
                  <thead>
                    <tr class="text-center">
                      <th>Pertemuan</th>
                      <th>Tanggal</th>
                      <th>Deskripsi</th>
                    </tr>
                  </thead>
                  <tbody class="text-center" id="body-pertemuan-modal">
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>


{{-- Modal Edit Validasi --}}
<div class="modal fade modalEditMateri" id="ModalEditMateri" tabindex="-1" role="dialog" aria-labelledby="ModalEditMateriTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="ModalEditMateriTitle">Edit Materi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <form action="{{ url('/akademik/materi')}}" method="post">
              @csrf
              <input type="hidden" class="id_program_les" name="id_program_les" id="id_program_les" value="{{$program_les->id_program_les}}">
              <div class="form-group">
                <label for="nama_program">Nama Program</label>
                <input class="form-control nama_program" id="nama_program" name="nama_program" value="{{$program_les->nama_program_les }}"
                  readonly>
              </div>
              <div class="form-group">
                <label for="validasi">Materi</label>
                <textarea name="materi" class="form-control" id="materi" rows="5">{{$program_les->cakupan_materi}}</textarea>
              </div>
              <div class="row">
                <div class="col-lg">
                  <button type="submit" class="btn btn-danger float-right">Edit Materi</button>
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