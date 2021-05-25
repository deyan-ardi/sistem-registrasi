@extends('user.layouts.app')

@section('title', 'Manajemen Member')

@section('header')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('footer')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
    <script>
        $('#image-login').tooltip('enable');
        $('#image-dashboard').tooltip('enable');
        $('#image-sidebar').tooltip('enable');

    </script>
@endsection
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h4 mb-4 text-primary">Setting Web App - {{ ucWords($setting->name_comunity) }}</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Web App {{ ucWords($setting->name_comunity) }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Logo Dashboard</th>
                                <th>Logo Sidebar</th>
                                <th>Logo Landing</th>
                                <th>Nama System</th>
                                <th>Nama Komunitas</th>
                                <th>Ekstensi Email Diijinkan</th>
                                <th>Fitur</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Logo Dashboard</th>
                                <th>Logo Sidebar</th>
                                <th>Logo Landing</th>
                                <th>Nama System</th>
                                <th>Nama Komunitas</th>
                                <th>Ekstensi Email Diijinkan</th>
                                <th>Fitur</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($setting_all as $all)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    @if (!empty($all->image_dashboard))
                                        <td><img width="40%" src="{{ asset('storage/' . $all->image_dashboard) }}"
                                                alt="Kosong"></td>
                                    @else
                                        <td><em>Kosong</em></td>
                                    @endif
                                    @if (!empty($all->image_sidebar))
                                        <td><img width="40%" src="{{ asset('storage/' . $all->image_sidebar) }}"
                                                alt="Kosong"></td>
                                    @else
                                        <td><em>Kosong</em></td>
                                    @endif
                                    @if (!empty($all->image_login))
                                        <td><img width="40%" src="{{ asset('storage/' . $all->image_login) }}"
                                                alt="Kosong"></td>
                                    @else
                                        <td><em>Kosong</em></td>
                                    @endif
                                    <td>{{ $all->name_system }}</td>
                                    <td>{{ $all->name_comunity }}</td>
                                    <td>{{ $all->type_email }}</td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#editSystem-{{ $all->id }}"
                                            class="btn btn-warning btn-sm btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                            <span class="text">Edit</span>
                                        </a>

                                        {{-- Modal Edit --}}
                                        <div class="modal fade" id="editSystem-{{ $all->id }}" tabindex="-1"
                                            aria-labelledby="addSystemLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addSystemLabel">Edit Informasi Sistem
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="user"
                                                            action="{{ route('edit-setting', [$all->id]) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('patch')
                                                            <div class="form-group">
                                                                <input id="image-sidebar" type="file" accept=".jpg,.png"
                                                                    class="form-control form-control-user @error('image_sidebar') is-invalid @enderror"
                                                                    name="image_sidebar" data-toggle="tooltip"
                                                                    data-placement="bottom" title="Sidebar Image">

                                                                @error('image_sidebar')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <input id="image-dashboard" type="file" accept=".jpg,.png"
                                                                    class="form-control form-control-user @error('image') is-invalid @enderror"
                                                                    name="image" data-toggle="tooltip"
                                                                    data-placement="bottom" title="Dashboard Image">

                                                                @error('image')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group">
                                                                <input id="image-login" type="file" accept=".jpg,.png"
                                                                    class="form-control form-control-user @error('image_landing') is-invalid @enderror"
                                                                    name="image_landing" data-toggle="tooltip"
                                                                    data-placement="bottom" title="Landing Page Image">

                                                                @error('image_landing')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <input id="name" type="text"
                                                                    class="form-control form-control-user @error('name') is-invalid @enderror"
                                                                    name="name" placeholder="Nama System"
                                                                    value="{{ $all->name_system }}" required>

                                                                @error('name')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <input id="comunity" type="text"
                                                                    class="form-control form-control-user @error('comunity') is-invalid @enderror"
                                                                    name="comunity" placeholder="Nama Comunity"
                                                                    value="{{ $all->name_comunity }}" required>

                                                                @error('comunity')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <input id="name" type="text"
                                                                    class="form-control form-control-user @error('email') is-invalid @enderror"
                                                                    name="email"
                                                                    placeholder="Ekstensi Email Yang Diperbolehkan (Tulis satu)"
                                                                    value="{{ $all->type_email }}" required>

                                                                @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>

                                                            <input type="hidden" name="edit" value="1">
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
