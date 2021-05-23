@extends('user.layouts.app')

@section('title', 'Activity Voting ' . $activity->name)

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <h1 class="h3 mb-0 text-gray-800">Surat Suara Elektronik <span
                class="text-primary">{{ ucWords($activity->name) }}</span>
        </h1>
        <p class="mb-4">Berikut merupakan kandidat yang dapat dipilih pada kegiatan {{ $activity->name }}</p>
        @if (\Carbon\Carbon::now() < \Carbon\Carbon::parse($activity->start))
            <div class="alert alert-primary">
                Kegiatan Evoting Dimulai {{ ucWords(\Carbon\Carbon::parse($activity->start)->diffForHumans()) }}
            </div>

        @elseif (\Carbon\Carbon::now() >= \Carbon\Carbon::parse($activity->start) && \Carbon\Carbon::now() <=
                \Carbon\Carbon::parse($activity->end))
                <div class="alert alert-info">
                    Kegiatan Evoting Sudah Dimulai dan Akan Berakhir
                    {{ ucWords(\Carbon\Carbon::parse($activity->end)->diffForHumans()) }}
                </div>
            @else
                <div class="alert alert-danger">
                    Kegiatan Evoting Sudah Berakhir {{ ucWords(\Carbon\Carbon::parse($activity->end)->diffForHumans()) }}
                </div>
        @endif
        <div class="row">
            @if (\Carbon\Carbon::now() < \Carbon\Carbon::parse($activity->start))
                <div class="col-12 mb-4">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Accordion -->
                        <a href="#collapseCard2" class="d-block card-header py-3" data-toggle="collapse" role="button"
                            aria-expanded="true" aria-controls="collapseCard2">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Kegiatan Evoting
                            </h6>
                        </a>
                        <!-- Card Content - Collapse -->
                        <div class="collapse show" id="collapseCard2">
                            <div class="card-body text-center">
                                <p>{{ ucWords($activity->name) }} Belum Dimulai</p>
                                <a href="/" class="btn btn-primary btn-sm">Ke Beranda</a>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(\Carbon\Carbon::now() >= \Carbon\Carbon::parse($activity->start) && \Carbon\Carbon::now() <=
                    \Carbon\Carbon::parse($activity->end))
                    @if (empty(Auth::user()->token))
                        <div class="col-12 mb-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCard2" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCard2">
                                    <h6 class="m-0 font-weight-bold text-primary">Informasi Token Evoting
                                    </h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCard2">
                                    <div class="card-body text-center">
                                        <p>Anda Belum Memiliki Token Pemilihan Untuk Mengikuti
                                            {{ ucWords($activity->name) }}. Silahkan Pilih Tombol Buat Token, Token Akan
                                            Dikirimkan Melalui Email Anda</p>
                                        <form action="{{ route('create-token', [Auth::user()->id, $activity->id]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-key"></i>
                                                Buat Token
                                                Pemilihan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @if (Auth::user()->status_voting == 0)
                            <div class="col-12 mb-4">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#tokenInform" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="tokenInform">
                                        <h6 class="m-0 font-weight-bold text-primary">Selamat Menggunakan Hak Pilih
                                        </h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="tokenInform">
                                        <div class="card-body text-center">
                                            <p>Token Pemilihan Telah Terkirim Melalui Email Akun Anda, Jika Anda Tidak Menerima Token Pemilihan Silahkan Pilih Buat Ulang</p>
                                            <form class="token-form" action="{{ route('create-token', [Auth::user()->id, $activity->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm tombol-token"><i
                                                        class="fa fa-key"></i> Buat Ulang Token
                                                    Pemilihan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @foreach ($all_candidate as $candidate)
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Accordion -->
                                        <a href="#collapseCard2" class="d-block card-header py-3" data-toggle="collapse"
                                            role="button" aria-expanded="true" aria-controls="collapseCard2">
                                            <h6 class="m-0 font-weight-bold text-primary">Kandidat No Undi
                                                {{ $candidate->order }}
                                            </h6>
                                        </a>
                                        <!-- Card Content - Collapse -->
                                        <div class="collapse show" id="collapseCard2">
                                            <div class="card-body text-center">
                                                <img style="height:170px; object-fit:cover; object-position:center;"
                                                    src="{{ asset($candidate->takeImage) }}" class="mb-3"
                                                    alt="Candidate Foto">
                                                <p class="mt-2">Undi {{ $candidate->order }} :</p>
                                                <h5 class="mb-4 text-primary">{{ ucWords($candidate->name) }}</h5>
                                                @if (Cookie::get('_auth_allow') == 1 && Cookie::get('_auth_allow'))
                                                    <a href="#" data-toggle="modal" data-target="#disable"
                                                        class="btn btn-primary col-lg-12 mt-4"> <i
                                                            class="fas fa-vote-yea"></i>
                                                        <span class="text">Pilih Kandidat Undi
                                                            {{ $candidate->order }}</span>
                                                    </a>
                                                @else
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#voteKandidat-{{ $candidate->id }}"
                                                        class="btn btn-primary col-lg-12 mt-4"> <i
                                                            class="fas fa-vote-yea"></i>
                                                        <span class="text">Pilih Kandidat Undi
                                                            {{ $candidate->order }}</span>
                                                    </a>
                                                @endif
                                                <!-- Modal -->

                                            </div>
                                            <div class="modal fade" id="voteKandidat-{{ $candidate->id }}" tabindex="-1"
                                                aria-labelledby="voteKandidatLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="voteKandidatLabel">Deskripsi
                                                                Kandidat No
                                                                Undi
                                                                {{ $candidate->order }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-justify">{!! $candidate->description !!}</p>
                                                            <hr style="width: 50%">
                                                            <form class="user mt-3"
                                                                action="{{ route('update-vote', [$activity->id, Auth::user()->id, $candidate->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('patch')
                                                                <div class="form-group">
                                                                    <label for="text">Untuk Mengkonfirmasi Pilihan Anda,
                                                                        Silahkan
                                                                        Masukkan
                                                                        Token Yang Telah Dikirimkan Ke Email Anda</label>
                                                                    <input id="text" type="text"
                                                                        class="form-control form-control-user @error('token') is-invalid @enderror"
                                                                        name="token" placeholder="Token Pemilihan"
                                                                        value="{{ old('token') }}" required>

                                                                    @error('token')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Pilih
                                                                        Kandidat</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 mb-4">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCard2" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="collapseCard2">
                                        <h6 class="m-0 font-weight-bold text-primary">Terimakasih Telah Berkontribusi
                                        </h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="collapseCard2">
                                        <div class="card-body text-center">
                                            <p>Bukti Pemilihan Dalam {{ ucWords($activity->name) }} Sudah Dikirim Ke
                                                Alamat
                                                Email Anda</p>
                                            <a href="/" class="btn btn-primary btn-sm">Ke Beranda</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @else
                    <div class="col-12 mb-4">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseCard2" class="d-block card-header py-3" data-toggle="collapse" role="button"
                                aria-expanded="true" aria-controls="collapseCard2">
                                <h6 class="m-0 font-weight-bold text-primary">Informasi Kegiatan Evoting
                                </h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse show" id="collapseCard2">
                                <div class="card-body text-center">
                                    <p>{{ ucWords($activity->name) }} Sudah Selesai Dilaksanakan, Terimakasi Atas
                                        Partisipasi Anda</p>
                                    <a href="/" class="btn btn-primary btn-sm">Ke Beranda</a>
                                </div>
                            </div>
                        </div>
                    </div>
            @endif

        </div>
    </div>
    <!-- /.container-fluid -->
    <div class="modal fade" id="disable" tabindex="-1" aria-labelledby="voteKandidatLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="voteKandidatLabel">Anda Terblokir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Anda memasukkan Token yang salah berulang-ulang, Anda Terblokir Untuk Sementara Waktu, Silahkan Coba
                    Lagi Nanti
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
