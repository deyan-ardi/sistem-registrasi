@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Informasi {{ ucWords($setting->name_system) }}</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Approach -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Ketentuan Penggunaan Sistem</h6>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>
                                <p>{{ ucWords($setting->name_system) }} Hanya Boleh Digunakan Oleh
                                    {{ ucWords($setting->name_comunity) }}</p>
                            </li>
                            <li>
                                <p>Hak Cipta Milik Ganatech.ID &copy; @php
                                    echo date('Y');
                                @endphp</p>
                            </li>
                            <li>
                                <p>Setiap Orang Dapat Menggunakan Sistem Ini Dengan Seijin Dari Pemilik Hak Cipta.</p>
                            </li>
                            <li>
                                <p> Dilarang Memperbanyak, Mengembangkan, Mendistribusikan, Menjual, ataupun Menerbitkan Sistem Ini
                                    Tanpa Ijin Tertulis Dari Pengembang</p>
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
