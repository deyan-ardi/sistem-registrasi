@extends('user.layouts.app')

@section('title', 'Manajemen Data Evoting')

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
    <script>
        if ($('#deskripsi1').val() != undefined) {
            CKEDITOR.replace('deskripsi1');
        }
        if ($('#deskripsi2').val() != undefined) {
            CKEDITOR.replace('deskripsi2');
        }

    </script>
@endsection
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800 mb-4">Rincian Data Evoting <span
                class="text-primary">{{ ucWords($admin->name) }}</span></h1>
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
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Jumlah Pemilih Evoting</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $detail_all->count() }} Pemilih
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Jumlah Member Komunitas </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $user_all->count() }} Pemilih</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($detail_all->count() != $user_all->count())
            <div class="alert alert-danger">Ada Member Baru Yang Ditambahkan, Silahkan Lakukan Sinkronasi Pemilih</div>
        @endif
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rincian Data Kegiatan Evoting</h6>
            </div>
            <div class="card-body">
                @if (\Carbon\Carbon::now() <= \Carbon\Carbon::parse($admin->end))
                    <div class="row">
                        <form action="{{ route('sinkronasi-pemilih', [$admin->id]) }}" class="mb-3" method="POST">
                            @csrf
                            @method('patch')
                            <button type="submit" class="btn btn-success btn-sm btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-sync"></i>
                                </span>
                                <span class="text">Sinkronasi Pemilih</span>
                            </button>
                        </form>
                        <form action="{{ route('reminder-all', [$admin->id]) }}" class="mb-3 ml-2" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-info btn-sm btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <span class="text">Kirim Token Ke Semua Member</span>
                            </button>
                        </form>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No KTA</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Akun Status</th>
                                <th>Voting Status</th>
                                <th>Token Status</th>
                                @if (\Carbon\Carbon::now() <= \Carbon\Carbon::parse($admin->end))
                                    <th>Fitur</th>
                                @endif
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>No KTA</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Akun Status</th>
                                <th>Voting Status</th>
                                <th>Token Status</th>
                                @if (\Carbon\Carbon::now() <= \Carbon\Carbon::parse($admin->end))
                                    <th>Fitur</th>
                                @endif
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($detail_all as $all)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $all->member_id }}</td>
                                    <td>{{ $all->name }}</td>
                                    @if (!empty($all->email))
                                        <td>{{ $all->email }}</td>
                                    @else
                                        <td><em>Kosong</em></td>
                                    @endif
                                    @if (!empty($all->email_verified_at))
                                        <td><a href="#" class="btn btn-success btn-sm">Aktif</a></td>
                                    @else
                                        <td><a href="#" class="btn btn-danger btn-sm">Tidak Aktif</a></td>
                                    @endif
                                    @if ($all->status_voting == '1')
                                        <td><a href="#" class="btn btn-success btn-sm">Sudah</a></td>
                                    @else
                                        <td><a href="#" class="btn btn-danger btn-sm">Belum</a></td>
                                    @endif
                                    @if (!empty($all->token))
                                        <td><a href="#" class="btn btn-success btn-sm">Terkirim</a></td>
                                    @else
                                        <td><a href="#" class="btn btn-danger btn-sm">Belum</a></td>
                                    @endif
                                    @if (\Carbon\Carbon::now() <= \Carbon\Carbon::parse($admin->end))
                                        <td>
                                            @if ($all->status_voting == '0' && !empty($all->email_verified_at))
                                                <form action="{{ route('reminder-vote', [$all->id, $admin->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-info btn-sm btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-envelope"></i>
                                                        </span>
                                                        <span class="text">Buat Token</span>
                                                    </button>
                                                </form>
                                            @elseif ($all->status_voting == '0' && empty($all->email_verified_at))
                                                <button class="btn btn-danger btn-sm btn-icon-split"
                                                    data-target="#belumAktif" data-toggle="modal">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                    <span class="text">Belum Aktif</span>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="belumAktif" tabindex="-1"
                                                    aria-labelledby="belumAktifLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="belumAktifLabel">Kirim Token
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Tidak dapat mengirimkan token, Akun pemilih belum diaktivasi
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <button class="btn btn-success btn-sm btn-icon-split"
                                                    data-target="#sudahMemilih" data-toggle="modal">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                    <span class="text">Sudah Memilih</span>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="sudahMemilih" tabindex="-1"
                                                    aria-labelledby="addVoteLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="addVoteLabel">Hubungi Pemilih
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Tidak dapat membuat token, Pemilih sudah melakukan
                                                                    pemilihan
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
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
                            <textarea name="deskripsi" id="deskripsi1"
                                class="form-control @error('deskripsi') is-invalid @enderror" cols="50" rows="10" required
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
