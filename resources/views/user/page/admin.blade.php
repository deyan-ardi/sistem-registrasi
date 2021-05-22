@extends('user.layouts.app')

@section('title', 'Administrator Voting')

@section('footer')
    <script>
        window.setTimeout("waktu()", 1000);

        function waktu() {
            var waktu = new Date();
            setTimeout("waktu()", 1000);
            if (document.getElementById("jam") != null || document.getElementById("menit") != null || document
                .getElementById("detik") != null) {
                document.getElementById("jam").innerHTML = waktu.getHours() + "	:";
                document.getElementById("menit").innerHTML = waktu.getMinutes() + "	:";
                document.getElementById("detik").innerHTML = waktu.getSeconds() + " WITA";
            }
        }

    </script>
@endsection
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Administrator <span class="text-primary">{{ ucWords($admin->name) }}</span>
            </h1>
        </div>
        @if (\Carbon\Carbon::now() < \Carbon\Carbon::parse($admin->start))
            <div class="alert alert-primary">
                Kegiatan Evoting Dimulai {{ ucWords(\Carbon\Carbon::parse($admin->start)->diffForHumans()) }}
            </div>
        @elseif (\Carbon\Carbon::now() >= \Carbon\Carbon::parse($admin->start) && \Carbon\Carbon::now() <= \Carbon\Carbon::parse($admin->end))
            <div class="alert alert-info">
                Kegiatan Evoting Sudah Dimulai dan Akan Berakhir {{ ucWords(\Carbon\Carbon::parse($admin->end)->diffForHumans()) }}
            </div>
        @else
            <div class="alert alert-danger">
                Kegiatan Evoting Sudah Berakhir {{ ucWords(\Carbon\Carbon::parse($admin->end)->diffForHumans()) }}
            </div>
        @endif

        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Jumlah Pemilih</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $vote + $not_vote }} Pemilih</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Surat Masuk </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $vote }} Pemilih</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sign-in-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Belum Memilih
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            {{ $not_vote }} Pemilih</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Waktu Sekarang
                                    <div class="col-auto col-12 row">
                                        <div class="h5 mb-0 mr-2 text-xs font-weight-bold text-gray-800">
                                            {{ Carbon\Carbon::now()->format('d F Y') }}
                                        </div>
                                    </div>
                                    <div class="col-auto col-12 row">

                                        <div class="h5 mb-0 mr-1 text-xs font-weight-bold text-gray-800" id="jam"></div>
                                        <div class="h5 mb-0 mr-1 text-xs font-weight-bold text-gray-800" id="menit"></div>
                                        <div class="h5 mb-0 mr-1 text-xs font-weight-bold text-gray-800" id="detik"></div>
                                    </div>
                                </div>
                                <div class="p mb-0 font-weight-bold text-gray-800"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#collapseCard2" class="d-block card-header py-3" data-toggle="collapse" role="button"
                        aria-expanded="true" aria-controls="collapseCard2">
                        <h6 class="m-0 font-weight-bold text-primary">Manajemen Evote
                        </h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="collapseCard2">
                        <div class="card-body">
                            <p class="text-justify"> Fitur ini digunakan untuk melihat status memilih, mensinkronasi data
                                pemilih, dan menghubungi pemilih
                                melalui email pemilih. Pada sistem ini tidak perlu menggunakan token untuk melakukan
                                pemilihan</p>
                            <a href="{{ route('management-evote', [$admin->id]) }}" type="submit"
                                class="btn btn-primary col-lg-12"> <i class="fas fa-sign-in-alt"></i>
                                <span class="text">Manajemen Data</span>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#collapseCard4" class="d-block card-header py-3" data-toggle="collapse" role="button"
                        aria-expanded="true" aria-controls="collapseCard4">
                        <h6 class="m-0 font-weight-bold text-primary">Database Kandidat
                        </h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="collapseCard4">
                        <div class="card-body">
                            <p class="text-justify"> Fitur ini digunakan untuk melihat, menambahkan, menghapus, dan mengubah
                                data kandidat yang
                                mengikuti kegiatan pemilihan ini. Gunakan ukuran foto 4:6 agar hasil foto yang muncul di
                                website menjadi lebih bagus</p>
                            <a href="{{ route('management-candidate', [$admin->id]) }}" type="submit"
                                class="btn btn-primary col-lg-12"> <i class="fas fa-sign-in-alt"></i>
                                <span class="text">Manajemen Data</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
