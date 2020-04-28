@extends('layout.layout') @section('title', 'Manajemen User') @section('container')
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
            <div class="card-header py-3 bg-danger">
                <h6 class="m-0 font-weight-bold text-capitalize text-white">Daftar User</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{ url('/admin/tambahUser') }}" class="btn btn-primary float-right">Tambah User</a>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-striped text-wrap" id="table-daftar-user">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Status User</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $u)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $u->username }}</td>
                                    <td>{{ $u->nama_status_user }}</td>
                                    <td>
                                        <button class="btn btn-warning edit_user" data-toggle="modal" data-target=".modalEditUser" data-id="{{ $u->id_user }}">Edit</button>
                                        <button class="btn btn-danger hapus_user" data-id="{{ $u->id_user }}">Hapus</button>
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


    <!-- Modal Edit User-->
    <div class="modal fade modalEditUser" id="ModalEditUser" tabindex="-1" role="dialog" aria-labelledby="ModalEditUserTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="ModalEditUserTitle">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <form action="{{ url('/admin/editUser/')}}" method="post">
                                @csrf
                                <input type="hidden" class="id_user" name="id_user" value="">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control username" id="username" name="username" value="" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control password" id="password" name="password" value="">
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