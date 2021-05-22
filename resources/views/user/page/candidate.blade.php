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
        <h1 class="h3 mb-4 text-gray-800">Manajemen Kandidat <span class="text-primary">{{ ucWords($admin->name) }}</span>
        </h1>
        @if (\Carbon\Carbon::now() < \Carbon\Carbon::parse($admin->start))
            <div class="alert alert-primary">
                Kegiatan Evoting Dimulai {{ ucWords(\Carbon\Carbon::parse($admin->start)->diffForHumans()) }}
            </div>

        @elseif (\Carbon\Carbon::now() >= \Carbon\Carbon::parse($admin->start) && \Carbon\Carbon::now() <=
                \Carbon\Carbon::parse($admin->end))
                <div class="alert alert-info">
                    Kegiatan Evoting Sudah Dimulai dan Akan Berakhir
                    {{ ucWords(\Carbon\Carbon::parse($admin->end)->diffForHumans()) }}
                </div>
            @else
                <div class="alert alert-danger">
                    Kegiatan Evoting Sudah Berakhir {{ ucWords(\Carbon\Carbon::parse($admin->end)->diffForHumans()) }}
                </div>
        @endif
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Kandidat</h6>
            </div>
            <div class="card-body">
                @if (\Carbon\Carbon::now() <= \Carbon\Carbon::parse($admin->end))
                    <a href="#" class="btn btn-sm btn-primary mb-3 btn-icon-split" data-toggle="modal"
                        data-target="#addCandidate">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Kandidat</span>
                    </a>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No Undi</th>
                                <th>Foto Kandidat</th>
                                <th>Nama Kandidat</th>
                                <th>Deskripsi</th>
                                @if (\Carbon\Carbon::now() <= \Carbon\Carbon::parse($admin->end))
                                    <th>Fitur</th>
                                @endif
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No Undi</th>
                                <th>Foto Kandidat</th>
                                <th>Nama Kandidat</th>
                                <th>Deskripsi</th>
                                @if (\Carbon\Carbon::now() <= \Carbon\Carbon::parse($admin->end))
                                    <th>Fitur</th>
                                @endif
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($candidate_all as $all)
                                <tr>
                                    <td>{{ $all->order }}</td>
                                    <td><img style="height:150px; object-fit:cover; object-position:center;"
                                            src="{{ asset($all->takeImage) }}" alt="Candidate Foto"></td>
                                    <td>{{ $all->name }}</td>
                                    <td>{!! $all->description !!}</td>
                                    @if (\Carbon\Carbon::now() <= \Carbon\Carbon::parse($admin->end))
                                        <td>
                                            <a href="#" data-toggle="modal"
                                                data-target="#editCandidate-{{ $all->id }}"
                                                class="btn btn-warning btn-sm btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Edit</span>
                                            </a>

                                            {{-- Modal Edit --}}

                                            <div class="modal fade" id="editCandidate-{{ $all->id }}" tabindex="-1"
                                                aria-labelledby="editCandidateLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editCandidateLabel">Tambah Kandidat
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="user"
                                                                action="{{ route('update-candidate', [$all->id]) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('patch')
                                                                <div class="form-group">
                                                                    <input id="file" type="file"
                                                                        class="form-control form-control-user @error('image') is-invalid @enderror"
                                                                        name="image" accept=".jpg,.png,.jpeg">

                                                                    @error('image')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <input id="text" type="text"
                                                                        class="form-control form-control-user @error('order') is-invalid @enderror"
                                                                        name="order" placeholder="No Undi"
                                                                        value="{{ $all->order }}" required>

                                                                    @error('order')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <input id="text" type="text"
                                                                        class="form-control form-control-user @error('name') is-invalid @enderror"
                                                                        name="name" placeholder="Nama Kandidat"
                                                                        value="{{ $all->name }}" required>

                                                                    @error('name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <textarea name="description" id="description"
                                                                        class="form-control ckeditor @error('description') is-invalid @enderror"
                                                                        cols="50" rows="10" required
                                                                        placeholder="Deskripsi Kandidat">{{ $all->description }}</textarea>
                                                                    @error('description')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                {{-- Hidden Input --}}
                                                                <input type="hidden" name="edit" value="1">
                                                                <input type="hidden" name="id_kegiatan"
                                                                    value="{{ $admin->id }}">
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
                                            <form action="{{ route('delete-candidate', [$all->id, $admin->id]) }}"
                                                class="mt-2" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                    <span class="text">Hapus</span>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
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
    <div class="modal fade" id="addCandidate" tabindex="-1" aria-labelledby="addCandidateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCandidateLabel">Tambah Kandidat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="user" action="{{ route('create-candidate') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input id="file" type="file"
                                class="form-control form-control-user @error('image') is-invalid @enderror" name="image"
                                accept=".jpg,.png,.jpeg" required>

                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="text" type="text"
                                class="form-control form-control-user @error('order') is-invalid @enderror" name="order"
                                placeholder="No Undi" value="{{ old('order') }}" required>

                            @error('order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="text" type="text"
                                class="form-control form-control-user @error('name') is-invalid @enderror" name="name"
                                placeholder="Nama Kandidat" value="{{ old('name') }}" required>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea name="description" id="description"
                                class="form-control ckeditor @error('description') is-invalid @enderror" cols="50" rows="10"
                                required placeholder="Deskripsi Kandidat">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <input type="hidden" name="edit" value="0">
                        <input type="hidden" name="id_kegiatan" value="{{ $admin->id }}">
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
