@extends('layouts.app')
@section('title')
    Login Sistem
@endsection
@section('content')
    <!-- Nested Row within Card Body -->
    <div class="row mt-3 mb-3">
        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-center">
                    @if (!empty($setting->image_login))
                       <img width="25%"
                            src="{{ asset('storage/' . $setting->image_login) }}" class="mb-4 rounded-circle"
                            alt="Kosong">
                    @endif
                    <h1 class="h4 text-gray-900 mb-2">{{ ucWords($setting->name_system) }}</h1>
                    <p class="mb-4">{{ ucWords($setting->name_comunity) }}</p>
                </div>
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <form class="user" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <input id="email" type="email"
                            class="form-control form-control-user @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" placeholder="example@mail.com" required autocomplete="email"
                            autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="password" type="password"
                            class="form-control form-control-user @error('password') is-invalid @enderror" name="password"
                            placeholder="********" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input class="custom-control-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label class="custom-control-label" for="remember">
                                {{ __('Tetap Masuk') }}
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        {{ __('Masuk') }}
                    </button>
                </form>
                <hr>
                <div class="text-center">
                    @if (Route::has('password.request'))
                        <a class="medium" href="{{ route('password.request') }}">
                            {{ __('Lupa Kata Sandi?') }}
                        </a>
                    @endif
                </div>
                <div class="text-center">
                    @if (Route::has('register'))
                        <a class="medium" href="{{ route('register') }}">
                            {{ __('Aktivasi Akun') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
