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
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
@endsection
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Manajemen Kegiatan Evoting {{ ucWords($setting->name_comunity) }}</h1>
        <p class="mb-4">Kegiatan Evoting {{ ucWords($setting->name_comunity) }}. Untuk membuat kegiatan Evoting baru, silahkan
            pilih Tambah Kegiatan. Anda hanya dapat mengaktifkan satu kegiatan Evoting pada waktu yang sama</p>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Kegiatan Evoting {{ ucWords($setting->name_comunity) }}</h6>
            </div>
            <div class="card-body">
                <a href="#" class="btn btn-sm btn-primary mb-3 btn-icon-split" data-toggle="modal" data-target="#addVote">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah Kegiatan</span>
                </a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Status Kegiatan</th>
                                <th>Nama Kegiatan</th>
                                <th>Deskripsi</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Administrator</th>
                                <th>Fitur</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Status Kegiatan</th>
                                <th>Nama Kegiatan</th>
                                <th>Deskripsi</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Administrator</th>
                                <th>Fitur</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($vote_all as $all)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    @if ($all->status == 1)
                                        <td>
                                            <form action="{{ route('disable', [$all->id]) }}" class="mt-2"
                                                method="POST">
                                                @csrf
                                                @method('patch')
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <span class="text">Aktif</span>
                                                </button>
                                            </form>
                                        </td>
                                    @else
                                        <td>
                                            <form action="{{ route('activate', [$all->id]) }}" class="mt-2"
                                                method="POST">
                                                @csrf
                                                @method('patch')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <span class="text">Tidak Aktif</span>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                    <td>{{ $all->name }}</td>
                                    <td>{!! $all->deskripsi !!}</td>
                                    <td>{{ date('d F Y, H:i', strtotime($all->start)) }} WITA</td>
                                    <td>{{ date('d F Y, H:i', strtotime($all->end)) }} WITA</td>
                                    <td><a href="{{ route('administrator',[$all->id]) }}" class="btn btn-info btn-sm">Admin Kegiatan</a></td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#editMember-{{ $all->id }}"
                                            class="btn btn-warning btn-sm btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                            <span class="text">Edit</span>
                                        </a>

                                        {{-- Modal Edit --}}
                                        <div class="modal fade" id="editMember-{{ $all->id }}" tabindex="-1"
                                            aria-labelledby="addVoteLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addMemberLabel">Edit Kegiatan Evoting
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="user" action="{{ route('edit-vote') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('patch')
                                                            <div class="form-group">
                                                                <input id="text" type="text"
                                                                    class="form-control form-control-user @error('name') is-invalid @enderror"
                                                                    name="name" placeholder="Nama Kegiatan"
                                                                    value="{{ $all->name }}" required>

                                                                @error('name')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <textarea name="deskripsi" id="deskripsi"
                                                                    class="form-control ckeditor @error('deskripsi') is-invalid @enderror"
                                                                    cols="50" rows="10" required
                                                                    placeholder="Deskripsi Kegiatan">{{ $all->deskripsi }}</textarea>
                                                                @error('deskripsi')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <input id="text" type="datetime"
                                                                    class="form-control form-control-user @error('start') is-invalid @enderror"
                                                                    name="start"
                                                                    placeholder="Format Tanggal Mulai Kegiatan (YYYY-MM-DD HH:MM:SS)"
                                                                    value="{{ $all->start }}" required>

                                                                @error('start')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <input id="text" type="datetime"
                                                                    class="form-control form-control-user @error('end') is-invalid @enderror"
                                                                    name="end"
                                                                    placeholder="Format Tanggal Selesai Kegiatan (YYYY-MM-DD HH:MM:SS)"
                                                                    value="{{ $all->end }}" required>

                                                                @error('end')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <input type="hidden" name="edit" value="1">
                                                            <input type="hidden" name="id" value="{{ $all->id }}">
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
                                        {{-- End Modal --}}
                                        <form action="{{ route('delete-vote', [$all->id]) }}" class="mt-2 hapus-form" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm tombol-hapus btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                                <span class="text">Hapus</span>
                                            </button>
                                        </form>
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

    <!-- Modal -->
    <div class="modal fade" id="addVote" tabindex="-1" aria-labelledby="addVoteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVoteLabel">Tambah Kegiatan Evoting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="user" action="{{ route('create-vote') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input id="text" type="text"
                                class="form-control form-control-user @error('name') is-invalid @enderror" name="name"
                                placeholder="Nama Kegiatan" value="{{ old('name') }}" required>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea name="deskripsi" id="deskripsi"
                                class="form-control ckeditor @error('deskripsi') is-invalid @enderror" cols="50" rows="10" required
                                placeholder="Deskripsi Kegiatan">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="text" type="datetime"
                                class="form-control form-control-user @error('start') is-invalid @enderror" name="start"
                                placeholder="Format Tanggal Mulai Kegiatan (YYYY-MM-DD HH:MM:SS)"
                                value="{{ old('start') }}" required>

                            @error('start')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="text" type="datetime"
                                class="form-control form-control-user @error('end') is-invalid @enderror" name="end"
                                placeholder="Format Tanggal Selesai Kegiatan (YYYY-MM-DD HH:MM:SS)"
                                value="{{ old('end') }}" required>

                            @error('end')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <input type="hidden" name="edit" value="0">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
