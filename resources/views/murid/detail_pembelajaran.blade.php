@extends('layout.layout')

@section('title', 'Detail Pembelajaran')

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
          <h6 class="m-0 font-weight-bold text-capitalize text-white">Pembelajaran Berjalan</h6>
        </div>
        <div class="card-body">
          <div class="card col-lg-12 mb-3" style="">
          <div class="row no-gutters">
            <div class="col-lg-3">
                <figure class="figure text-center">
                    <img src="{{ URL::asset($detail_kelas->image) }}" class="img-thumbnail rounded" style="width: 100%; height: 100%;" alt="{{$detail_kelas->nama_kelas}}">
                    <figcaption class="figure-caption mt-3">
                        <h4>{{$detail_kelas->nama_kelas}}</h4>
                        <h4>{{$detail_kelas->nama_program_les}}</h4>
                        <h4 class="text-danger">Nilai Evaluasi : {{$detail_kelas->nilai_evaluasi}}</h4>
                    </figcaption>
                </figure>
            </div>
            <div class="col-lg-9">
              <div class="card-body">
                <div class="table-responsive">
                    @if(count($detail_kelas->pertemuan) == 0)
                        <div class="alert alert-warning text-center mt-2 mb-2 col-lg-12">Belum ada pertemuan</div>
                    @else
                    <table class="table table-striped text-wrap" id="table-pertemuan">
                        <thead>
                            <tr class="text-center">
                                <th>Pertemuan</th>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Kehadiran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($detail_kelas->pertemuan as $p)
                                <tr class="text-center">
                                  <td>{{$p->pertemuan_ke}}</td>
                                  <td>{{$p->tgl_indo}}</td>
                                  <td>{{$p->deskripsi}}</td>
                                  @if($p['kehadiran']->kehadiran == 1)
                                  <td class="text-success">Hadir</td>
                                  @else
                                  <td class="text-danger">Tidak Hadir</td>
                                  @endif
                                  @if($p['kehadiran']->feedback == null)
                                  <td><button class="btn btn-danger feedback" data-toggle="modal" data-target=".modalFeedback" data-id="{{$p['kehadiran']->id_kehadiran}}">Tambah Feedback</button></td>
                                  @else 
                                  <td><button class="btn btn-success detail-feedback ml-3" data-toggle="modal" data-target=".modalDetailFeedback" data-id="{{$p['kehadiran']->id_kehadiran}}">Detail Feedback</button></td>
                                  @endif
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    @endif

                    <a class="float-right" href="{{ url('/murid/pembelajaran') }}" style="text-decoration: none;">
                        <button class="mr-3 d-none d-lg-inline text-gray-600 small btn btn-secondary" ><span class="text-white">Kembali</span></button>
                    </a>

                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  
  </div>



  <!-- Modal -->
  <div class="modal fade modalFeedback" id="ModalFeedback" tabindex="-1" role="dialog" aria-labelledby="ModalFeedbackTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="ModalFeedbackTitle">Feedback {{ $detail_kelas->nama_kelas}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <figure class="figure text-center">
                            <img src="{{ URL::asset($detail_kelas->image) }}" class="img-thumbnail rounded" style="width: 100%; height: 100%;" alt="{{ $detail_kelas->nama_kelas }}">
                        </figure>
                    </div>
                    <div class="col-lg-8">
                        <form action="{{ url('/murid/feedback/')}}" method="post" id="form-pertemuan">
                            @csrf
                            <input type="hidden" name="username" value="">
                            <input type="hidden" id="id_kehadiran" name="id_kehadiran" value="">
                            <input type="hidden" id="id_kelas" name="id_kelas" value="{{ $detail_kelas->id_kelas }}">
                            <div class="form-group">
                                <label for="pertemuan">Pertemuan</label>
                                <input type="text" class="form-control" id="pertemuan" name="pertemuan" readonly>
                            </div>
                            <div class="form-group">
                                <label for="feeedback">Feedback</label>
                                <textarea class="form-control" name="feedback" id="feedback" rows="10"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg">
                                    <button type="submit" class="btn btn-danger float-right">Tambah Feedback</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>




    <div class="modal fade modalDetailFeedback" id="ModalDetailFeedback" tabindex="-1" role="dialog" aria-labelledby="ModalDetailFeedbackTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="ModalDetailFeedbackTitle">Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <figure class="figure text-center">
                                <img src="{{ URL::asset($detail_kelas->image) }}" class="img-thumbnail rounded" style="width: 200px; height: 200px;" alt="{{ $detail_kelas->nama_kelas }}">
                            </figure>
                        </div>
                        <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="pertemuan-detail">Pertemuan</label>
                                    <input type="text" class="form-control" id="pertemuan-detail" name="pertemuan-detail" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="feeedback-detail">Feedback</label>
                                    <textarea class="form-control" name="feedback-detail" id="feedback-detail" readonly rows="10"></textarea>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
@endsection                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 