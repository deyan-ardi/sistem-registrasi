    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>


        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                    @if (!empty(Auth::user()->image))
                        <img class="img-profile rounded-circle" src="{{ asset('storage/' . Auth::user()->image) }}">
                    @else
                        <img class="img-profile rounded-circle" src="{{ asset('storage/user/profile.svg') }}">
                    @endif
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profilModal">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Pengaturan Profil
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Keluar Sistem
                        </button>
                    </form>
                </div>
            </li>

        </ul>

    </nav>
    <!-- End of Topbar -->

    <!-- Modal -->
    <div class="modal fade" id="profilModal" tabindex="-1" aria-labelledby="profilModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profilModalLabel">Ubah Profil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="user" action="{{ route('update-login', [Auth::user()->id]) }}" method="POST"
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
                        @php
                            $cut = explode('@', Auth::user()->email);
                            $hasil = substr($cut[0], 0, -5);
                            
                        @endphp
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user " disabled
                                value="{{ $hasil . '*****@' . $cut['1'] }}">
                        </div>

                        <div class="form-group">
                            <input id="file" type="file" accept=".jpg,.png" title=" Pilih Foto Profil "
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
                                class="form-control form-control-user @error('phone') is-invalid @enderror"
                                name="phone" placeholder="Nomor Telepon"
                                value="{{ old('phone') ?? Auth::user()->phone }}" required>

                            @error('phone')
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
