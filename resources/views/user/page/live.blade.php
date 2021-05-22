@extends('user.layouts.app')

@section('title', 'Activity Voting ' . $activity->name)
@section('footer')
    <!-- Page level plugins -->
    <script>
        let sudah_memilih = "{{ $sudah }}";
        let belum_memilih = "{{ $belum }}";
        let count = "{{ $candidate->count() }}"
        let labels = [];
        let total = [];
        for (i = 1; i <= count; i++) {
            labels.push(document.querySelector('#cand-' + i).value);
            total.push(document.querySelector('#val-' + i).value);
        }

    </script>
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-bar-demo.js') }}"></script>
@endsection
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Hitung Cepat Evoting <span
                class="text-primary">{{ ucWords($activity->name) }}</span>
        </h1>
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
            @else
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Accordion -->
                        <a href="#collapseCard" class="d-block card-header py-3" data-toggle="collapse" role="button"
                            aria-expanded="true" aria-controls="collapseCard">
                            <h6 class="m-0 font-weight-bold text-primary">Hitung Cepat Berdasarkan Kandidat
                            </h6>
                        </a>
                        <!-- Card Content - Collapse -->
                        <div class="collapse show" id="collapseCard">
                            <div class="card-body text-center">
                                <div class="chart-pie pt-4">
                                    <canvas id="myBarChart"></canvas>
                                </div>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($candidate as $c)
                                    <input type="hidden" value="{{ $c->count }}" id="val-{{ $i }}">
                                    <input type="hidden" value="{{ $c->name }}" id="cand-{{ $i }}">
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                                <hr>
                                Total Kandidat Yang Dapat Dipilih Sebanyak <span
                                    class="text-primary">{{ $candidate->count() }}</span> Orang Kandidat
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Accordion -->
                        <a href="#collapseCard2" class="d-block card-header py-3" data-toggle="collapse" role="button"
                            aria-expanded="true" aria-controls="collapseCard2">
                            <h6 class="m-0 font-weight-bold text-primary">Hitung Cepat Berdasarkan Member
                            </h6>
                        </a>
                        <!-- Card Content - Collapse -->
                        <div class="collapse show" id="collapseCard2">
                            <div class="card-body text-center">
                                <div class="chart-pie pt-4">
                                    <canvas id="myPieChart2"></canvas>
                                </div>
                                <hr>
                                Total Member Yang Mengikuti Kegiatan Vote Sebanyak <span
                                    class="text-primary">{{ $sudah + $belum }}</span> Orang Member
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection
