<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    {{--
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous"> --}}

    <!-- Custom fonts for this template-->
    <link href="{{URL::asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="{{URL::asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('css/all.css')}}" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Viga&display=swap" rel="stylesheet">

    <!-- My CSS -->
    <link rel="stylesheet" href="{{URL::asset('css/styles.css')}}">
    <link rel="icon" href="{{URL::asset('image/icon.png')}}">

    <title>Naoyuki Academic Center</title>
</head>

<body id="home">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="{{URL::asset('image/Naoyuki.png')}}" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                    <a class="nav-item nav-link active" href="#home">Home <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="#program">Program</a>
                    <a class="nav-item nav-link" href="#informasi">Informasi</a> @if(session()->has('username'))
                    <a class="nav-item nav-link" href="{{'/'}}">Dashboard</a>
                    <a class="nav-item nav-link" href="#">Hai, {{session('username')}}</a> @else
                    <a class="nav-item nav-link" href="{{' / '}}">Login</a> @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Akhir Navbar -->

    <!-- Jumbotron -->
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">NAOYUKI ACADEMIC CENTER</h1>
            <p>Les Bahasa Jepang</p>
        </div>
    </div>
    <!-- Akhir Jumbotron -->

    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col">
                <h1>Program Les</h1>
                <hr>
            </div>
        </div>

        <section id="program">
            <div class="row justify-content-center text-center mt-2">
                <?php 
                $program_les = \App\Program_Les::all();
                ?> @foreach ($program_les as $pl)
                <div class="col-lg-4 mt-2">
                    <button class="program" data-toggle="modal" data-toggle="modal" data-target=".ModalDetailProgram" data-id="{{ $pl->id_program_les }}">
                        <figure class="figure">
                            <img src="{{URL::asset($pl->image)}}" class="img-thumbnail" style="width: 300px; height: 300px;">
                            <figcaption class="figure-caption">
                                <h5>{{ $pl->nama_program_les }}</h5>
                            </figcaption>
                        </figure>
                    </button>
                </div>
                @endforeach
            </div>
            {{--
            <div class="row justify-content-center text-center mt-3">
                <div class="col">
                    <button class="btn btn-danger">Lihat Selengkapnya</button>
                </div>
            </div> --}}
        </section>

        <section id="informasi">
            <div class="row justify-content-center text-center mt-5">
                <div class="col">
                    <h1>Informasi</h1>
                    <hr>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-lg-5">
                    <img src="{{URL::asset('image/tes.jpg')}}">
                </div>
                <div class="col-lg-5">
                    <div class="row">
                        <img src="{{URL::asset('image/alamat_icon.png')}}" style="width:40px;height:40px;">
                        <p class="ml-2 mt-2">Gd. Inbis Lt. 4, Malang</p>
                    </div>
                    <div class="row mt-2">
                        <img src="{{URL::asset('image/fb_icon.png')}}" style="width:40px;height:40px;">
                        <p class="ml-2 mt-2">Naoyuki Academic Center</p>
                    </div>
                    <div class="row mt-2">
                        <img src="{{URL::asset('image/mail_icon.png')}}" style="width:40px;height:40px;">
                        <p class="ml-2 mt-2">naoyuki.id@gmail.com</p>
                    </div>
                    <div class="row mt-2">
                        <img src="{{URL::asset('image/ig_icon.png')}}" style="width:40px;height:40px;">
                        <p class="ml-2 mt-2">naoyuki.id</p>
                    </div>
                    <div class="row mt-2">
                        <img src="{{URL::asset('image/no_icon.png')}}" style="width:40px;height:40px;">
                        <p class="ml-2 mt-2">(+62) 811-3696-997</p>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <div class="container-fluid">
        <!-- Footer -->
        <div class="row footer">
            <div class="col text-center">
                <p>Copyright @
                    <?= date('Y') ?> Naoyuki Academic Center</p>
            </div>
        </div>
        <!-- Akhir Footer -->

    </div>
    <!-- Akhir Container -->


    <!-- Modal Detail -->

    <!-- Modal -->
    <div class="modal fade ModalDetailProgram" id="ModalDetailProgram" tabindex="-1" role="dialog" aria-labelledby="ModalDetailProgramTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalDetailProgramTitle">Detail Program</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <figure class="figure">
                                <img src="{{URL::asset('image/thumbnail.jpg')}}" class="img-thumbnail image-info">
                                <figcaption class="figure-caption text-center mt-2">
                                    <h5 class="judul-caption">Intermediate Grammar</h5>
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



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    {{--
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous">
    </script> --}}
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