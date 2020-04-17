<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    {{--  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">  --}}

    <!-- Custom fonts for this template-->
    <link href="{{URL::asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    
        <!-- Custom styles for this template-->
        <link href="{{URL::asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/all.css')}}" rel="stylesheet">
        
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Viga&display=swap" rel="stylesheet">

    <!-- My CSS -->
    <link rel="stylesheet" href="{{URL::asset('css/login.css')}}">
    <link rel="icon" href="{{URL::asset('image/icon.png')}}">

    <title>Login</title>

</head>

<body class="bg-blue">
    <div class="container mt-4" style="width: 100%; height: 100%;">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-12 col-sm-12 col-lg-12 col-md-12 mt-3">
                <div class="card o-hidden border-0 shadow-lg my-5" style="width: 100%; border-radius:20px;">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block text-center ml-4 mt-5 login">
                                <img src="{{URL::asset('image/study.svg')}}" class="rounded mx-auto d-block mt-5 ml-3" style="width: 100%;">
                                <div class="mt-5 mb-0 text-center">
                                    <p>@ Copyright 2019 Naoyuki Academic Center</p>
                                </div>
                            </div>
                            <div class="col-lg-5 col-sm-12 mx-auto">
                                <div class="pt-5">
                                    <div class="text-center div-title">
                                        <h5 class="title mb-4 mt-0">Selamat Datang di</h5>
                                        <h3 class="title mb-3 mt-0 font-weight-bold text-danger">NAOYUKI ACADEMIC CENTER</h3>
                                    </div>
                                    @if (session('statusEror'))
                                        <div class="alert alert-danger text-center p-0 mb-2">{{ session('statusEror') }}</div>
                                    @elseif(session('statusLogout'))    
                                        <div class="alert alert-success text-center p-0 mb-2">{{ session('statusLogout') }}</div>
                                    @endif
                                    <form class="user" method="post" action="{{url('/auth')}}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control form-control-user @error('username') is-invalid @enderror" id="username" name="username" placeholder="Masukkan Username" style=" border-radius:20px;" value="{{ old('username') }}">
                                            @error('username')
                                            <div class="invalid-feedback ml-2">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan Password" style=" border-radius:20px;">
                                            @error('password')
                                            <div class="invalid-feedback ml-2">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger col-lg" style=" border-radius:20px;">Login</button>
                                        </div>
                                    </form>
                                    <div class="text-center mb-4">
                                        <a href="{{url('/landing')}}" class="text-center">Klik disini untuk informasi program les</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    </div>
    <p class="text-center" style="margin-top: -30px; font-size: .7rem;">Copyright © <?= date('Y') ?> Naoyuki Academic Center. All Rights Reserved. </p>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    {{--  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>  --}}

    <!-- Bootstrap core JavaScript-->
    <script src="{{URL::asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{URL::asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{URL::asset('js/sb-admin-2.min.js')}}"></script>
    <script src="{{URL::asset('js/landing.js')}}"></script>

</body>

</html>