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
                    <img src="{{URL::asset(url('image/thumbnail.jpg'))}}" class="img-thumbnail rounded" style="width: 200px; height: 200px;">
                    <figcaption class="figure-caption mt-3">
                        <h4>"Sakura"</h4>
                        <h4>Basic Grammar</h4>
                        <h4 class="text-danger">Nilai Evaluasi : 0</h4>
                    </figcaption>
                </figure>
            </div>
            <div class="col-lg-9">
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped text-wrap" id="">
                        <thead>
                            <tr class="text-center">
                                <th>Pertemuan</th>
                                <th>Deskripsi</th>
                                <th>Kehadiran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr class="text-center">
                            <td>1</td>
                            <td>Hiragana</td>
                            <td class="text-success">Hadir</td>
                            <td><button class="btn btn-danger feedback" data-toggle="modal" data-target=".modalFeedback">Feedback</button><button class="btn btn-success detail-feedback ml-3" data-toggle="modal" data-target=".modalDetailFeedback">Detail Feedback</button></td>
                        </tr>
                          <tr class="text-center">
                            <td>2</td>
                            <td>Katakana</td>
                            <td class="text-success">Hadir</td>
                            <td><button class="btn btn-danger feedback" data-toggle="modal" data-target=".modalFeedback">Feedback</button><button class="btn btn-success detail-feedback ml-3" data-toggle="modal" data-target=".modalDetailFeedback">Detail Feedback</button></td>
                        </tr>
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
  
  </div>



  <!-- Modal -->
  <div class="modal fade modalFeedback" id="ModalFeedback" tabindex="-1" role="dialog" aria-labelledby="ModalFeedbackTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="ModalFeedbackTitle">Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <figure class="figure text-center">
                            <img src="{{URL::asset(url('image/thumbnail.jpg'))}}" class="img-thumbnail rounded" style="width: 200px; height: 200px;">
                        </figure>
                    </div>
                    <div class="col-lg-8">
                        <form action="{{ url('/murid/feedback/')}}" method="post">
                            @csrf
                            <input type="hidden" name="username" value="">
                            <div class="form-group">
                                <label for="pertemuan">Pertemuan</label>
                                <input type="text" class="form-control" id="pertemuan" name="pertemuan" readonly value="1">
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
                                <img src="{{URL::asset(url('image/thumbnail.jpg'))}}" class="img-thumbnail rounded" style="width: 200px; height: 200px;">
                            </figure>
                        </div>
                        <div class="col-lg-8">
                                <input type="hidden" name="username" value="">
                                <div class="form-group">
                                    <label for="pertemuan">Pertemuan</label>
                                    <input type="text" class="form-control" id="pertemuan" name="pertemuan" readonly value="1">
                                </div>
                                <div class="form-group">
                                    <label for="feeedback">Feedback</label>
                                    <textarea class="form-control" name="feedback" id="feedback" readonly rows="10">Pertemuan kali ini pembahasannya sangat seru sekali, belajar bahasa jepang untuk pertama kalinya</textarea>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
@endsection                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 