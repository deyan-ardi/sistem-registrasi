@extends('layouts.app')
@section('title')
    Reset Kata Sandi
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
                    <h1 class="h4 text-gray-900 mb-2">Reset Kata Sandi</h1>
                    <p class="mb-4">Silahkan Masukkan Kata Sandi Baru Anda</p>
                </div>
                <form class="user" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <input id="email" type="email"
                            class="form-control form-control-user @error('email') is-invalid @enderror" name="email"
                            value="{{ $email ?? old('email') }}" placeholder="example@mail.com" required
                            autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="password" type="password"
                            class="form-control form-control-user @error('password') is-invalid @enderror" name="password"
                            placeholder="********" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="password-confirm" type="password" class="form-control form-control-user"
                            name="password_confirmation" placeholder="********" required autocomplete="new-password">
                    </div>
                    <button type="submit" class="btn btn-primary  btn-user btn-block">
                        {{ __('Simpan Kata Sandi Baru') }}
                    </button>

                </form>
            </div>
        </div>
    </div>
@endsection
