@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('footer')
    <script>
        const previewImg = () => {
            const file = document.getElementById('file');
            const imgPreview = document.querySelector('.img-preview');

            const fileSampul = new FileReader();
            fileSampul.readAsDataURL(file.files[0]);
            fileSampul.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }

    </script>
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
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-primary">Pengaturan Profil - {{ ucWords($setting->name_system) }}</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-8 mb-4">
                <!-- Approach -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Profil Umum</h6>
                    </div>
                    <div class="card-body">
                        <form class="user" action="{{ route('update-profil', [Auth::user()->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user " disabled
                                    value="{{ Str::substr(Auth::user()->member_id, 0, -5) }}***** (No KTA)">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user " disabled
                                    value="{{ Str::substr(Auth::user()->nik, 0, -5) }}***** (No KTP)">
                            </div>
                            <div class="form-group">
                                <input id="file" type="file" accept=".jpg,.png" onchange="previewImg()"
                                    title=" Pilih Foto Profil "
                                    class="form-control form-control-user @error('image') is-invalid @enderror"
                                    name="image">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="text" type="text"
                                    class="form-control form-control-user @error('name_login') is-invalid @enderror"
                                    name="name_login" placeholder="Nama Member"
                                    value="{{ old('name_login') ?? Auth::user()->name }}" required>

                                @error('name_login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="text" type="number" minlength="9" maxlength="15"
                                    class="form-control form-control-user @error('phone') is-invalid @enderror" name="phone"
                                    placeholder="Nomor Telepon" value="{{ old('phone') ?? Auth::user()->phone }}"
                                    required>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Keamanan Akun</h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger" style="display: none" id="pesan">Only Accepts The
                            {{ $setting->type_email }}
                            Email Extension</div>
                        <form class="user" action="{{ route('update-keamanan', [Auth::user()->id]) }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <input id="email" type="email"
                                    class="form-control form-control-user @error('email') is-invalid @enderror" name="email"
                                    placeholder="Email Member" value="{{ old('email') ?? Auth::user()->email }}"
                                    required>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="text" type="password"
                                    class="form-control form-control-user @error('password_login') is-invalid @enderror"
                                    name="password_login" placeholder="Password Baru (Jika Ingin Merubah)">
                                @error('password_login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="text" type="password" class="form-control form-control-user"
                                    name="repassword_login" placeholder="Konfirmasi Password (Jika Ingin Merubah)">
                            </div>
                            <button type="submit" id="tombol_request" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="widget widget-map">
                    <div class="widget-map-area">
                        @if (!empty(Auth::user()->image))
                            <img class="img-profile img-thumbnail border-primary img-preview"
                                src="{{ asset('storage/' . Auth::user()->image) }}">
                        @else
                            <img class="img-profile img-thumbnail border-primary img-preview"
                                src="{{ asset('storage/user/profile.svg') }}">
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection
