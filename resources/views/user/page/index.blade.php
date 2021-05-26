@extends('user.layouts.app')

@section('title', 'Dashboard')
@section('footer')
    <script>
        waktu();

        function waktu() {
            var waktu = new Date();
            setTimeout("waktu()", 1000);
            if (document.getElementById("jam") != null || document.getElementById("menit") != null) {
                document.getElementById("jam").innerHTML = waktu.getHours() + "	:";
                document.getElementById("menit").innerHTML = waktu.getMinutes() + " WITA";
            }
        }

    </script>
@endsection
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-primary">Dashboard - {{ ucWords($setting->name_comunity) }}</h1>
            <div class="row">
                <div class="h5 mb-0 mr-1 text-xs font-weight-bold text-primary">{{ date('l, d F Y') }} |</div>
                <div class="h5 mb-0 mr-1 text-xs font-weight-bold text-primary" id="jam"></div>
                <div class="h5 mb-0 mr-1 text-xs font-weight-bold text-primary" id="menit"></div>

            </div>
        </div>
        <!-- Content Row -->
        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-3">
                                @if (!empty(Auth::user()->image))
                                    <img class="img-profile rounded-circle"
                                        src="{{ asset('storage/' . Auth::user()->image) }}">
                                @else
                                    <img class="img-profile rounded-circle" src="{{ asset('storage/user/profile.svg') }}">
                                @endif
                            </div>
                            <div class="col-1"></div>
                            <div class="col-8">
                                <div class="h5 text-gray mb-1">
                                    Selamat Datang,</div>
                                <div class="h5 mb-0 font-weight-bold text-dark text-bold mb-2">
                                    {{ ucWords(Auth::user()->name) }}</div>
                                <div class="text-xs font-weight-bold text-primary">
                                    {{ Auth::user()->email }} <a href="{{ route('edit-profil') }}"><i class="fa fa-user-edit"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card bg-gradient-custom shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 font-weight-bold text-light text-uppercase mb-4">
                                    Kartu Anggota WMD</div>
                                <div class="h5 mb-0 font-weight-bold text-light">{{ Auth::user()->member_id }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-3x text-light"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-12 text-center">
                                @if (!empty($setting->image_dashboard))
                                    <a href="http://wirausahamudadenpasar.org/">
                                        <img width="50%" src="{{ asset('storage/' . $setting->image_dashboard) }}"
                                            alt="Kosong">
                                    </a>
                                @else
                                    <a href="http://wirausahamudadenpasar.org/">
                                        <h5>{{ $setting->name_system }}</h5>
                                        <h5>{{ $setting->name_comunity }}</h5>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row mt-3">
            <div class="col-lg-6 mb-4">
                <h5 class="mb-3">Event</h5>
                <div class="alert alert-info">
                    Belum Ada Event
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <h5 class="mb-3">Berita atau Pengumuman</h5>
                <div class="alert alert-info">
                   Belum Ada Berita atau Pengumuman
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection
