@extends('layout.layout')

@section('title', 'Program Les')

@section('container')
<div class="row">
  <div class="col-lg-6 col-md-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 bg-danger">
        <h6 class="m-0 font-weight-bold text-capitalize text-white">Daftar Semua Program Les</h6>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="table-responsive">
            <table class="table table-striped text-wrap" id="table-daftar-program">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Foto Program</th>
                        <th>Nama Program</th>
                        <th>Jumlah Pertemuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($program_les as $pl) 
                  <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td><img src="{{ URL::asset($pl->image) }}" class="img-fluid img-profile" alt="..." style="width: 100px; height:100px;"></td>
                    <td>{{ $pl->nama_program_les }}</td>
                    <td>{{ $pl->jumlah_pertemuan }} Kali</td>
                    <td><button class="btn btn-primary detailProgram" data-toggle="modal" data-target=".modalDetailProgramLes" data-id="{{ $pl->id_program_les }}">Detail</button></td>
                  </tr>
                  @endforeach 
                </tbody>
            </table>
        </div>
        </div>
      
        {{-- <div class="row justify-content-center text-center mt-2"> --}}
                      
         
        
        {{-- <div class="card col-lg-3 mx-2 my-2" style="width: 18rem;">
          <img src="{{ URL::asset($pl->image) }}" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">{{ $pl->nama_program_les }}</h5>
            <a href="#" class="card-text float-right mt-5"><small class="text-danger">Detail</small></a>
          </div>
        </div> --}}

        {{-- <div class="card mb-3" style="max-width: 350px;">
          <div class="row no-gutters">
            <div class="col-md-4">
              <img src="{{ URL::asset($pl->image) }}" class="card-img" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">{{ $pl->nama_program_les }}</h5>
                <a href="#" class="card-text float-right"><small class="text-danger">Detail</small></a>
              </div>
            </div>
          </div>
        </div> --}}
        
        
      {{-- </div> --}}


      </div>
    </div>
  </div>

  <div class="col-lg-6 col-md-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 bg-danger">
        <h6 class="m-0 font-weight-bold text-capitalize text-white">Program Les Terdaftar</h6>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="table-responsive">
            <table class="table table-striped text-wrap" id="table-program-berjalan">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Foto Program</th>
                        <th>Nama Program</th>
                        <th>Jumlah Pertemuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($program_berjalan as $pb) 
                  <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td><img src="{{ URL::asset($pl->image) }}" class="img-fluid img-profile" alt="..." style="width: 100px; height:100px;"></td>
                    <td>{{ $pb->nama_program_les }}</td>
                    <td>{{ $pb->jumlah_pertemuan }} Kali</td>
                    <td>
                      @if($pb->status_pendaftaran == 0)
                      <p class="text-danger">Belum Valid</p><a href="{{url('/murid/pembayaran/'.$pb->id_pendaftaran)}}" class="btn btn-warning">Bayar</a>
                      @elseif($pb->status_pendaftaran == 2)
                      <p class="text-warning">Sedang diproses</p>
                      @else
                      <p class="text-success">Valid</p>
                      @endif
                    </td>
                    <td><button class="btn btn-primary" data-toggle="modal" data-target=".modalDetailProgramTerdaftar" data-id="{{ $pl->id_program_les }}">Detail</button></td>
                  </tr>
                  @endforeach 
                </tbody>
            </table>
        </div>
        </div>
      </div>
    </div>
  </div>


  <div class="col-lg-12 col-md-12 mb-4">
    <div class="row">
      <div class="col-lg">
          <a href="{{ url('/murid/daftarProgram') }}" class="btn btn-danger p-5 float-right"><i class="fas fa-plus"></i><span>Daftar Program</span></a>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade modalDetailProgramLes" id="modalDetailProgramLes" tabindex="-1" role="dialog" aria-labelledby="ModalDetailProgramLesTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="ModalDetailProgramLesTitle">Detail Program</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="row justify-content-center">
                  <div class="col-lg-4">
                      <figure class="figure">
                          <img src="" class="img-thumbnail image-info">
                          <figcaption class="figure-caption text-center mt-2">
                              <h5 class="judul-caption"></h5>
                          </figcaption>
                      </figure>
                  </div>
              </div>

              <div class="row justify-content-center mb-4">
                  <div class="col-lg-4 text-center">
                      <h5>Pertemuan</h5>
                      <h5 class="border p-3 pertemuan-les"></h5>
                  </div>
                  <div class="col-lg-4 text-center">
                      <h5>Deskripsi</h5>
                      <h5 class="border p-3 deskripsi-les"></h5>
                  </div>
                  <div class="col-lg-4 text-center">
                      <h5>Cakupan Materi</h5>
                      <h5 class="border p-3 materi-les"></h5>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 