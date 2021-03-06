<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title')</title>

  <!-- Custom fonts for this template-->
  <link href="{{URL::asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  
  <!-- Custom styles for this template-->
  <link href="{{URL::asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('css/all.css')}}" rel="stylesheet">
  <link rel="icon" href="{{URL::asset('image/icon.png')}}">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gray-900 sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('/')}}">
        <div class="sidebar-brand-icon rotate-n-15">
          <img src="{{URL::asset('image/icon.png')}}" style="width: 75px; height: 75px;" alt="icon_naoyuki">
        </div>
        <div class="sidebar-brand-text mx-3">NAOYUKI</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider mb-0">
      <li class="nav-item mt-0">
        <a class="nav-link" href="{{url('/')}}">
          <img src="{{ URL::asset(session('image_profil')) }}" class="img-profile rounded-circle mr-2" alt="{{ session('username') }}"></img>
          @if(session('status_user') == 1 && session('status_user') == 2)
          <span>{{ session('nama_lengkap') }}</span>
          @else
          <span>{{ session('username') }}</span>
          @endif
        </a>
      </li>
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading mt-2">
        {{ session('nama_status_user') }}
      </div>

      <!-- Nav Item - Dashboard -->
      @if($title == "Dashboard")
      <li class="nav-item active">
      @else
      <li class="nav-item">
      @endif
      <a class="nav-link" href="{{url('/')}}">
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span></a>
      </li>

      <?php 
      $sub_menu = DB::table('user_sub_menu')->where(['id_menu' => session('status_user')])->get()->toArray();
      ?>

      @foreach ($sub_menu as $sm)
        @if($title == $sm->judul)
        <li class="nav-item active">
        @else
        <li class="nav-item">
        @endif
        <a class="nav-link" href="{{ url($sm->url) }}">
          <i class="{{ $sm->ikon }}"></i>
          <span>{{ $sm->judul }}</span></a>
        </li>
      @endforeach

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block mb-0">
      <li class="nav-item">
        <a class="nav-link" href="#" onclick="logout()">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Logout</span></a>
      </li>
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            @if(session('status_user') == 3 || session('status_user') == 4)
            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                @if($notifikasi['count_notif'] != 0)
                <span class="badge badge-danger badge-counter">{{$notifikasi['count_notif']}}</span>
                @endif
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Notifikasi
                </h6>
                @if(count($notifikasi['notif']) == 0)
                <div class="alert alert-warning text-center mb-2 col-lg-12">Tidak ada notifikasi</div>
                @else
                @foreach($notifikasi['notif'] as $notif)
                {{--  Seleksi Notifikasi  --}}
                @if(session('status_user') == 3)
                {{--  Akademik  --}}
                <a class="dropdown-item d-flex align-items-center" href="{{url('/akademik/tambahKelas/'.$notif->id_program_les)}}">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-book text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">{{$notif->tgl_indo}}</div>
                    <span class="text-primary">{{$notif->nama_lengkap}}</span> Menunggu Kelas Program <span class="text-success">{{$notif->nama_program_les}}</span>
                  </div>
                </a>
                @else
                {{--  Finance  --}}
                <a class="dropdown-item d-flex align-items-center" href="{{url('/finance/validasi/')}}">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-book text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">{{$notif->tgl_indo .' Pukul '.$notif->waktu_pendaftaran}}</div>
                    <span class="text-primary">{{$notif->nama_lengkap}}</span> Melakukan konfirmasi pembayaran Kelas Program <span class="text-success">{{$notif->nama_program_les}}</span>
                  </div>
                </a>
                @endif
                {{--  Akhir Seleksi Notifikasi  --}}
                @endforeach
                @endif
                {{--  <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>  --}}
              </div>
            </li>
            @endif

            <li class="nav-item no-arrow mx-1">
                <a class="nav-link" href="{{ url('/landing') }}">
                    <button class="mr-2 d-none d-lg-inline text-gray-600 small btn btn-danger"><span class="text-white">Landing Page</span></button>
                </a>
              </li>
            <!-- Nav Item - Messages -->

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ session('username') }}</span>
                <img class="img-profile rounded-circle" src="{{ URL::asset(session('image_profil')) }}" alt="{{ session('username') }}">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                @if(session('status_user') == 1)
                <a class="dropdown-item" href="{{ url('/profil') }}">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profil
                </a>
                @endif
                <a class="dropdown-item logout" href="#" onclick="logout()">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
        
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
          <div class="tanggal">
            <div class="text-md mb-0 font-weight-bold text-gray-400">
              <span><i class="fas fa-calendar-alt text-gray-400 mr-2"></i></span> {{ $tanggal }}
            </div>
          </div>
        </div>

        @yield('container')

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright @ <?= date('Y') ?> Naoyuki Academic Center</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="{{URL::asset('vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{URL::asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{URL::asset('js/sb-admin-2.min.js')}}"></script>
  
  <!-- Custom scripts for sweet alert-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script src="{{URL::asset('js/sweet-alert.js')}}"></script>
  
  <!-- Page level plugins -->
  {{-- <script src="{{URL::asset('vendor/chart.js/Chart.min.js')}}"></script> --}}
  
  <!-- Page level custom scripts -->
  {{-- <script src="{{URL::asset('js/demo/chart-area-demo.js')}}"></script> --}}
  {{-- <script src="{{URL::asset('js/demo/chart-pie-demo.js')}}"></script> --}}
  
  
  @if(Request::segment(2) == "jadwal")
  @if(Request::segment(1) == "murid")
  <script src="{{URL::asset('js/murid_date.js')}}"></script>
  @else
  <script src="{{URL::asset('js/sensei_date.js')}}"></script>
  @endif
  <!-- Full Calendar -->
  <link href='{{ URL::asset('/packages/core/main.css') }}' rel='stylesheet' />
  <link href='{{ URL::asset('/packages/daygrid/main.css') }}' rel='stylesheet' />
  <link href='{{ URL::asset('/packages/timegrid/main.css') }}' rel='stylesheet' />
  <link href='{{ URL::asset('/packages/list/main.css') }}' rel='stylesheet' />
  <link href='{{ URL::asset('/packages/bootstrap/main.css') }}' rel='stylesheet' />
  <script src='{{ URL::asset('/vendor/rrule.js') }}'></script>
  <script src='{{ URL::asset('/packages/core/main.js') }}'></script>
  <script src='{{ URL::asset('/packages/core/locales-all.js') }}'></script>
  <script src='{{ URL::asset('/packages/interaction/main.js') }}'></script>
  <script src='{{ URL::asset('/packages/daygrid/main.js') }}'></script>
  <script src='{{ URL::asset('/packages/timegrid/main.js') }}'></script>
  <script src='{{ URL::asset('/packages/list/main.js') }}'></script>
  <script src='{{ URL::asset('/packages/rrule/main.js') }}'></script>
  <script src='{{ URL::asset('/packages/bootstrap/main.js') }}'></script>
  @endif

  <!-- JS Libraies -->
<script src="{{ URL::asset('/modules/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/modules/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('/modules/datatables/dataTables.select.min.js') }}"></script>
<script src="{{ URL::asset('/modules/select/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('/modules/datepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('/modules/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ URL::asset('/modules/jquery-ui/jquery.mask.js') }}"></script>
<script src="{{ URL::asset('/modules/select/jquery.selectric.min.js') }}"></script>
<script src="{{ URL::asset('/modules/ionicons/modules-ion-icons.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ URL::asset('js/murid.js') }}"></script>
<script src="{{ URL::asset('js/sensei.js') }}"></script>
<script src="{{ URL::asset('js/akademik.js') }}"></script>
<script src="{{ URL::asset('js/finance.js') }}"></script>
<script src="{{ URL::asset('js/admin.js') }}"></script>

</body>

</html>