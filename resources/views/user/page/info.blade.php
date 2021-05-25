@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-primary">Informasi - {{ ucWords($setting->name_system) }}</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Approach -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Sistem</h6>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>
                                <p>{{ ucWords($setting->name_system) }} Dikembangkan Oleh
                                    {{ ucWords($setting->name_comunity) }}</p>
                            </li>
                            <li>
                                <p>Dikembangkan Menggunakan Framework Laravel 7.30.4</p>
                            </li>
                            <li>
                                <p>Template Web Menggunakan <a href="https://startbootstrap.com/theme/sb-admin-2">SB Admin 2</a></p>
                            </li>
                            <li>
                                <p>Versi Stable 1.0</p>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection
