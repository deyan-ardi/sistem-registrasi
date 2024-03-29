@extends('layouts.app')

@section('title')
    Aktivasi Akun Komunitas
@endsection

@section('footer')
    <script>
        document.getElementById('email').onkeyup = function() {
            let email = document.getElementById('email').value;
            let strArray = email.split("@");
            if (strArray[1] != "") {
                if (strArray[1] == "{{ $setting->type_email }}") {
                    document.getElementById('tombol_request').disabled = false;
                    document.getElementById('pesan').style.display = "none";
                } else {
                    document.getElementById('tombol_request').disabled = true;
                    document.getElementById('pesan').style.display = "block";
                }
            }
        }

    </script>
@endsection

@section('content')
    <!-- Nested Row within Card Body -->
    <div class="row mt-3 mb-3">
        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-center">
                    @if (!empty($setting->image_login))
                        <img width="25%" src="{{ asset('storage/' . $setting->image_login) }}" class="mb-4 rounded-circle"
                            alt="Kosong">
                    @endif
                    <h1 class="h4 text-gray-900 mb-4">Aktivasi Akun Komunitas</h1>
                    <p class="mb-4">Silahkan melakukan aktivasi akun agar dapat login ke sistem
                        {{ ucWords($setting->name_system) }}
                    </p>
                </div>
                <div class="alert alert-danger" style="display: none" id="pesan">Only Accepts The
                    {{ $setting->type_email }}
                    Email Extension</div>
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form class="user" method="POST" novalidate action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <input id="nik" type="text"
                            class="form-control form-control-user @error('nik') is-invalid @enderror" name="nik"
                            value="{{ old('nik') }}" placeholder="No KTP" required autocomplete="nik">

                        @error('nik')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="member_id" type="text"
                            class="form-control form-control-user @error('member_id') is-invalid @enderror" name="member_id"
                            value="{{ old('member_id') }}" placeholder="No Kartu Tanda Anggota" required
                            autocomplete="member_id">

                        @error('member_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="name" type="text"
                            class="form-control form-control-user @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" placeholder="Nama Member" required
                            autocomplete="name">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="phone" type="number" min="0" maxlength="15"
                            class="form-control form-control-user @error('phone') is-invalid @enderror" name="phone"
                            value="{{ old('phone') }}" placeholder="No Telepon" required
                            autocomplete="phone">

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    <div class="form-group">
                        <input id="email" type="email"
                            class="form-control mt-3 form-control-user @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" placeholder="example@mail.com" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input id="password" type="password"
                                class="form-control form-control-user @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password" placeholder="********">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <input id="password-confirm" type="password" class="form-control form-control-user"
                                name="password_confirmation" placeholder="********" required autocomplete="new-password">
                        </div>
                    </div>
                    <button type="submit" id="tombol_request" class="btn btn-primary btn-user btn-block">
                        {{ __('Aktivasi Akun') }}
                    </button>
                </form>
                <hr>
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
