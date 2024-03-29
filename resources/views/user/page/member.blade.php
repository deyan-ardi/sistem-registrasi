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
@endsection
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h4 mb-4 text-primary">Manajemen Member - {{ ucWords($setting->name_comunity) }}</h1>

        @if (isset($errors) && $errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $err)
                    {{ $err }}
                @endforeach
            </div>
        @endif
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Member {{ ucWords($setting->name_comunity) }}</h6>
            </div>
            <div class="card-body">
                <div class="row">

                    <a href="#" class="btn btn-sm btn-primary mb-3 btn-icon-split" data-toggle="modal"
                        data-target="#addMember">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Member</span>
                    </a>
                    <a href="#" class="btn btn-sm btn-success mb-3 ml-2 btn-icon-split" data-toggle="modal"
                        data-target="#importMember">
                        <span class="icon text-white-50">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="text">Import Excel</span>
                    </a>
                    <a href="{{ route('export-member') }}" class="btn btn-sm btn-info mb-3 ml-2 btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-download"></i>
                        </span>
                        <span class="text">Export To Excel</span>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No KTA</th>
                                <th>No KTP</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No Telepon</th>
                                <th>Akun Status</th>
                                <th>Level</th>
                                <th>Akun Dibuat</th>
                                <th>Akun Diaktivasi</th>
                                <th>Fitur</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>No KTA</th>
                                <th>No KTP</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No Telepon</th>
                                <th>Akun Status</th>
                                <th>Level</th>
                                <th>Akun Dibuat</th>
                                <th>Akun Diaktivasi</th>
                                <th>Fitur</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($member_all as $all)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $all->member_id }}</td>
                                    <td>{{ $all->nik }}</td>
                                    <td>{{ $all->name }}</td>
                                    @if (!empty($all->email))
                                        <td>{{ $all->email }}</td>
                                    @else
                                        <td><em>Kosong</em></td>
                                    @endif
                                    @if (!empty($all->phone))
                                        <td>{{ $all->phone }}</td>
                                    @else
                                        <td><em>Kosong</em></td>
                                    @endif

                                    @if (!empty($all->email_verified_at))
                                        <td><a href="#" class="btn btn-success btn-sm">Aktif</a></td>
                                    @else
                                        <td><a href="#" class="btn btn-danger btn-sm">Tidak Aktif</a></td>
                                    @endif
                                    @if ($all->level == 'user')
                                        <td><a href="#" class="btn btn-info btn-sm">User</a></td>
                                    @else
                                        <td><a href="#" class="btn btn-info btn-sm">Admin</a></td>
                                    @endif
                                    {{-- Diganti jadi created_at --}}
                                    <td>{{ $all->created_at->diffForHumans() }}</td>

                                    @if (!empty($all->email_verified_at))
                                        <td>{{ $all->email_verified_at->diffForHumans() }}</td>
                                    @else
                                        <td><a href="#" class="btn btn-danger btn-sm">Belum Ada</a></td>
                                    @endif
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
                                            aria-labelledby="addMemberLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addMemberLabel">Edit Member</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="user" action="{{ route('edit-member') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('patch')
                                                            <div class="form-group">
                                                                <input id="text" type="text"
                                                                    class="form-control form-control-user @error('member_id') is-invalid @enderror"
                                                                    name="member_id" placeholder="No KTA"
                                                                    value="{{ $all->member_id }}" required>

                                                                @error('member_id')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <input id="text" type="text"
                                                                    class="form-control form-control-user @error('nik') is-invalid @enderror"
                                                                    name="nik" placeholder="No KTP"
                                                                    value="{{ $all->nik }}" required>

                                                                @error('nik')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <input id="text" type="text"
                                                                    class="form-control form-control-user @error('name') is-invalid @enderror"
                                                                    name="name" placeholder="Nama Member"
                                                                    value="{{ $all->name }}" required>

                                                                @error('name')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <input id="text" type="email"
                                                                    class="form-control form-control-user @error('email') is-invalid @enderror"
                                                                    name="email" placeholder="Email Member"
                                                                    value="{{ old('email') ?? $all->email }}">

                                                                @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <input id="text" type="password"
                                                                    class="form-control form-control-user @error('password') is-invalid @enderror"
                                                                    name="password"
                                                                    placeholder="Password Baru (Jika Ingin Merubah)">
                                                                @error('password')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <input id="text" type="password"
                                                                    class="form-control form-control-user" name="repassword"
                                                                    placeholder="Konfirmasi Password (Jika Ingin Merubah)">
                                                            </div>
                                                            <div class="form-group form-check">
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <input type="radio"
                                                                            {{ $all->level == 'user' ? 'checked' : '' }}
                                                                            name="level" value="user" id="user"
                                                                            class="form-check-input form-control-user">
                                                                        <label class="form-check-label"
                                                                            for="user">User</label>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input type="radio"
                                                                            {{ $all->level == 'admin' ? 'checked' : '' }}
                                                                            name="level" value="admin" id="admin"
                                                                            class="form-check-input form-control-user">
                                                                        <label class="form-check-label"
                                                                            for="admin">Admin</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="edit" value="1">
                                                            <input type="hidden" name="id" value="{{ $all->id }}"
                                                                required>
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
                                        <form id="hapus-form-{{ $all->id }}" action="{{ route('delete-member', [$all->id]) }}" class="mt-2"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button id="tombol-hapus-{{ $all->id }}" type="submit" class="btn btn-danger btn-sm btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                                <span class="text">Hapus</span>
                                            </button>
                                        </form>
                                             <script>
                                            $("#tombol-hapus-{{ $all->id }}").on("click", function(e) {
                                                e.preventDefault();
                                                Swal.fire({
                                                    title: "Apakah Anda Yakin Ingin Menghapus {{ $all->name }}?",
                                                    text: "Informasi Yang Terkait Dengan Data Ini Akan Hilang Secara Permanen",
                                                    icon: "warning",
                                                    showCancelButton: true,
                                                    confirmButtonColor: "#3085d6",
                                                    cancelButtonColor: "#d33",
                                                    cancelButtonText: "Batal",
                                                    confirmButtonText: "Yakin"
                                                }).then(result => {
                                                    if (result.value) {
                                                        $("#hapus-form-{{ $all->id }}").submit();
                                                    }
                                                });
                                            });
                                        </script>
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
    <div class="modal fade" id="addMember" tabindex="-1" aria-labelledby="addMemberLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberLabel">Tambah Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="user" action="{{ route('create-member') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input id="text" type="text"
                                class="form-control form-control-user @error('member_id') is-invalid @enderror"
                                name="member_id" placeholder="No KTA" value="{{ old('member_id') }}" required>

                            @error('member_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="text" type="text"
                                class="form-control form-control-user @error('nik') is-invalid @enderror" name="nik"
                                placeholder="No KTP" value="{{ old('nik') }}" required>

                            @error('nik')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="text" type="text"
                                class="form-control form-control-user @error('name') is-invalid @enderror" name="name"
                                placeholder="Nama Member" value="{{ old('name') }}" required>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <input type="hidden" name="edit" value="0">
                        <input type="hidden" name="level" value="user" required>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="importMember" tabindex="-1" aria-labelledby="addMemberLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberLabel">Import Excel Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="user" action="{{ route('import-member') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input id="text" type="file" accept=".xlsx"
                                class="form-control form-control-user @error('import') is-invalid @enderror" name="import"
                                required>

                            @error('import')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <p>Silahkan import data member komunitas dengan menggunakan format berikut (<span
                                class="text-primary"><a href="{{ asset('format_file_upload.xlsx') }}">Format Upload
                                    Excel</a></span>)</p>
                        <input type="hidden" name="level" value="user" required>
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
