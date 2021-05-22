@extends('layouts.app')
@section('title')
    Lupa Kata Sandi
@endsection
@section('content')
    <!-- Nested Row within Card Body -->
    <div class="row mt-3 mb-3">
        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-center">
                    @if (!empty($setting->image_system))
                        <img style="height:85px; width:85px; object-fit:cover; object-position:center; "
                            src="{{ asset('storage/' . $setting->image_system) }}" class="rounded-circle mb-4"
                            alt="Kosong">
                    @endif
                    <h1 class="h4 text-gray-900 mb-2">Lupa Kata Sandi?</h1>
                    <p class="mb-4">Silahkan Masukkan Email Akun Anda, Kami Akan Mengirimkan Email Untuk Mereset Kata Sandi
                        Akun Anda</p>
                </div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="user" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <input id="email" type="email"
                            class="form-control form-control-user @error('email') is-invalid @enderror" name="email"
                            placeholder="example@mail.com" value="{{ old('email') }}" required autocomplete="email"
                            autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        {{ __('Kirimkan Email Reset Kata Sandi') }}
                    </button>
                </form>
                <hr>
                <div class="text-center">
                    @if (Route::has('register'))
                        <a class="small" href="{{ route('register') }}">
                            {{ __('Aktivasi Akun') }}
                        </a>
                    @endif
                </div>
                <div class="text-center">
                    @if (Route::has('login'))
                        <a class="small" href="{{ route('login') }}">
                            {{ __('Sudah Punya Akun? Login') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
