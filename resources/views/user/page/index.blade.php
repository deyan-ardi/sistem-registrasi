@extends('user.layouts.app')

@section('title','Dashboard')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard {{ ucWords($setting->name_system) }}</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Approach -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Hai, {{ ucWords(Auth::user()->name) }}</h6>
                    </div>
                    <div class="card-body">
                        <p>Selamat Datang Di {{ ucWords($setting->name_system) }}, Sistem Informasi ini digunakan untuk melakukan manajemen komunitas serta melaksanakan kegiatan Evoting {{ ucWords($setting->name_comunity) }}. Berikut detail login Anda :</p>
                        <ul>
                            @php
                                $cut = explode('@',Auth::user()->email);
                                $hasil = substr($cut[0],0,-5);
                                
                            @endphp    
                            <li>ID Member : {{ Str::substr(Auth::user()->member_id, 0, -5) }}*****</li>
                            <li>Nama : {{ Auth::user()->name }}</li>
                            <li>Email : @php
                                echo $hasil."*****@".$cut['1'];    
                            @endphp
                            </li>
                            <li>Bergabung : {{ Auth::user()->email_verified_at->diffForHumans() }}</li>
                        </ul>
                        <p>Mohon jaga kerahasiaan informasi akun anda</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection
