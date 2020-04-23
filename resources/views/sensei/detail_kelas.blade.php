@extends('layout.layout') @section('title', 'Detail Kelas') @section('container')
<div class="row">
  <div class="col-lg-12">
    @if (session('status'))
    <div class="alert alert-success text-center mb-2">{{ session('status') }}</div>
    @endif
  </div>

  <div class="col-xl-6 col-md-6 col-lg-6 mb-4 dftr">
    <div class="card border-left-danger shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-danger mb-1">
              {{ $detail_kelas->nama_program_les }}</div>
            <div class="h4 mb-0 font-weight-bold text-gray-800 mt-3"> {{ $detail_kelas->nama_kelas }}
            </div>
            @foreach($detail_kelas->jadwal as $jadwal)
            <div class="h4 mb-0 font-weight-bold text-gray-800 mt-3"> {{ $jadwal->hari.' '.substr($jadwal->jam_mulai,0,5). ' - '.substr($jadwal->jam_selesai,0,5)}} 
            </div>
            @endforeach
          </div>
          <div class="col-auto">
            <i class="fas fa-users fa-4x text-danger"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-6 col-md-6 col-lg-6 mb-4 dftr">
    <div class="card border-left-danger shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-danger mb-1">
              Materi</div>
            <div class="h4 mb-0 font-weight-bold text-gray-800 mt-3"><span></span> {{ $detail_kelas->cakupan_materi }}
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
        <h6 class="m-0 font-weight-bold text-capitalize text-white">Daftar Peserta Kelas</h6>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="table-responsive">
            <table class="table table-striped text-wrap" id="table-daftar-peserta">
              <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th>Nama Murid</th>
                  <th>Nilai Evaluasi</th>
                  <th>Kehadiran</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody class="text-center">
                @foreach ($detail_kelas->peserta as $dkp)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $dkp->nama_lengkap }}</td>
                  <td>{{ $dkp->nilai_evaluasi }}</td>
                  <td>{{ $dkp->jumlah_hadir.'/'. $detail_kelas->jumlah_pertemuan }}</td>
                  <td>
                    <button class="btn btn-primary detail_peserta_kelas" data-toggle="modal" data-target=".modalDetailMurid" data-id="{{ $dkp->username }}">Detail</button>
                    <button class="btn btn-warning detail_nilai_peserta" data-toggle="modal" data-target=".modalNilaiMurid" data-id="{{ $dkp->id_peserta_kelas }}">Edit Nilai</button>
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

  {{-- Daftar Laporan Pertemuan --}}
  <div class="col-lg-12 col-md-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 bg-danger">
        <h6 class="m-0 font-weight-bold text-capitalize text-white">Laporan Pertemuan</h6>
      </div>
      <div class="card-body">
        @if(count($detail_kelas->pertemuan)
        < $detail_kelas->jumlah_pertemuan)
          <div class="row">
            <div class="col-lg-12">
              <a href="{{ url('/sensei/tambahLaporan/'.$detail_kelas->id_kelas ) }}" class="btn btn-danger float-right mb-3">Tambah Laporan Pertemuan</a>
            </div>
          </div>
          @endif
          <div class="row">
            <div class="table-responsive">
              
          @if(count($detail_kelas->pertemuan) == 0)
          <div class="alert alert-warning text-center mt-2 mb-2 col-lg-12">Belum ada pertemuan</div>
          @else
              <table class="table table-striped text-wrap" id="table-daftar-pertemuan">
                <thead>
                  <tr class="text-center">
                    <th>Pertemuan</th>
                    <th>Tanggal</th>
                    <th>Deskripsi Laporan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  @foreach ($detail_kelas->pertemuan as $p)
                  <tr>
                    <td>{{ $p->pertemuan_ke }}</td>
                    <td>{{ $p->tanggal_indo }}</td>
                    <td>{{ $p->deskripsi }}</td>
                    <td>
                      <button class="btn btn-primary detail_kehadiran" data-toggle="modal" data-target=".modalDetailKehadiran" data-id="{{ $p->id_pertemuan }}">Detail</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              @endif

              <a class="float-right" href="{{ url('/sensei/pembelajaran') }}" style="text-decoration: none;">
                <button class="mr-3 d-none d-lg-inline text-gray-600 small btn btn-secondary" ><span class="text-white">Kembali</span></button>
            </a>

            </div>
          </div>


      </div>
    </div>
  </div>

</div>

<!-- Modal Detail Murid -->
<div class="modal fade modalDetailMurid" id="ModalDetailMurid" tabindex="-1" role="dialog" aria-labelledby="ModalDetailMuridTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="ModalDetailMuridTitle">Detail Peserta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <figure class="figure text-center">
              <img src="{{URL::asset(session('image_profil'))}}" class="img-thumbnail rounded-circle image-profil" style="width: 350px; height: 350px;">
            </figure>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="nama_lengkap">Nama Lengkap</label>
              <input type="text" class="form-control nama_lengkap" id="" name="nama_lengkap" value="" readonly>
            </div>
            <div class="form-group">
              <label for="email_p">Email</label>
              <input type="text" class="form-control email_p" id="" name="email_p" value="" readonly>
            </div>
            <div class="form-group">
              <label for="no_telp_p">Nomor Telepon</label>
              <input type="text" class="form-control no_telp_p" id="" name="no_telp_p" value="" readonly>
            </div>
            <div class="form-group">
              <label for="asal_sekolah_p">Asal Sekolah</label>
              <input type="text" class="form-control asal_sekolah_p" id="" name="asal_sekolah_p" value="" readonly>
            </div>
            <div class="form-group">
              <label for="alamat_p">Alamat</label>
              <input type="text" class="form-control alamat_p" id="" name="alamat_p" value="" readonly>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal Nilai Murid --}}
<div class="modal fade modalNilaiMurid" id="ModalNilaiMurid" tabindex="-1" role="dialog" aria-labelledby="ModalNilaiMuridTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="ModalNilaiMuridTitle">Edit Nilai Murid</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <form action="{{ url('/sensei/editNilaiMurid/')}}" method="post">
              @csrf
              <input type="hidden" name="id_peserta_kelas" value="" class="id_peserta_kelas">
              <input type="hidden" name="id_kelas" value="{{$detail_kelas->id_kelas}}">
              <div class="form-group">
                <label for="nama_lengkap_nilai">Nama Lengkap</label>
                <input type="text" class="form-control nama_lengkap_nilai" id="" name="nama_lengkap_nilai" value="" readonly>
              </div>
              <div class="form-group">
                <label for="nilai_evaluasi">Nilai Evaluasi</label>
                <input type="number" class="form-control nilai_evaluasi" id="" name="nilai_evaluasi">
              </div>
              <div class="row">
                <div class="col-lg">
                  <button type="submit" class="btn btn-danger float-right">Edit Nilai</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


{{-- Modal Detail Kehadiran --}}
<div class="modal fade modalDetailKehadiran" id="ModalDetailKehadiran" tabindex="-1" role="dialog" aria-labelledby="ModalDetailKehadiranTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="ModalDetailKehadiranTitle">Detail Pertemuan <span class="pertemuan-judul"></span>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="table-responsive">
            <table class="table table-striped text-wrap" id="">
              <thead>
                <tr class="text-center">
                  <th>Nama Murid</th>
                  <th>Status Kehadiran</th>
                  <th>Feedback</th>
                </tr>
              </thead>
              <tbody class="text-center kehadiran_murid">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection