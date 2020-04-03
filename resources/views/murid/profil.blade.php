@extends('layout.layout') @section('title', 'Profil Murid') @section('container')
<div class="row">
    <div class="col-lg-12">
        @if (session('status'))
        <div class="alert alert-success text-center mb-2">{{ session('status') }}</div>
        @elseif (session('gagal'))
        <div class="alert alert-danger text-center mb-2">{{ session('gagal') }}</div>
        @endif
    </div>
    <div class="col-lg-12 col-md-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row justify-content-left">
                    <div class="col-lg-3 mr-5">
                        <figure class="figure text-center">
                            <img src="{{URL::asset(session('image_profil'))}}" class="img-thumbnail rounded-circle" style="width: 300px; height: 300px;">
                            <figcaption class="figure-caption mt-3">
                                <h3>{{ session('nama_lengkap') }}</h3>
                                <button class="btn btn-primary mt-2 editProfil" data-toggle="modal" data-target=".modalEditProfil" data-id="{{ session('username') }}
                            "><i class="fas fa-fw fa-edit"></i><span> Edit Profil</span></button>
                            </figcaption>
                        </figure>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <h2 class="mt-5">Nama: {{ $profil['nama_lengkap'] }}</h2>
                        </div>
                        <div class="row">
                            <h2 class="mt-4">Email: {{ $profil['email'] }}</h2>
                        </div>
                        <div class="row">
                            <h2 class="mt-4">No. Telepon: {{ $profil['no_hp'] }}
                                <h2>
                        </div>
                        <div class="row">
                            <h2 class="mt-4">Asal Sekolah: {{ $profil['asal_sekolah'] }}</h2>
                        </div>
                        <div class="row">
                            <h2 class="mt-4">Alamat: {{ $profil['alamat'] }}</h2>
                        </div>
                    </div>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-2 ml-0">
                        <img src="{{URL::asset('image/user-solid.svg')}}" style="width: 300px; height: 300px;;" class="mt-5 mr-5 pr-5">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit Profil-->
<div class="modal fade modalEditProfil" id="ModalEditProfil" tabindex="-1" role="dialog" aria-labelledby="ModalEditProfilTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="ModalEditProfilTitle">Edit Profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <figure class="figure text-center">
                            <img src="{{URL::asset(session('image_profil'))}}" class="img-thumbnail rounded-circle" style="width: 350px; height: 350px;">
                        </figure>
                    </div>
                    <div class="col-lg-6">
                        <form action="{{ url('/murid/editProfil/')}}" method="post">
                            @csrf
                            <input type="hidden" name="username" value="{{ $profil['username'] }}">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="{{ $profil['email'] }}">
                            </div>
                            <div class="form-group">
                                <label for="no_telp">Nomor Telepon</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{ $profil['no_hp'] }}">
                            </div>
                            <div class="form-group">
                                <label for="asal_sekolah">Asal Sekolah</label>
                                <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" value="{{ $profil['asal_sekolah'] }}">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $profil['alamat'] }}">
                            </div>
                            <div class="row">
                                <div class="col-lg">
                                    <button type="submit" class="btn btn-danger float-right">Edit</button>
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