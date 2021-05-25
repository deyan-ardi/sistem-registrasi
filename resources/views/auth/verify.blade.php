@extends('layouts.app')

@section('title')
    Verifikasi Alamat Email
@endsection

@section('content')
    <div class="row mt-3 mb-3">
        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-center">
                        @if (!empty($setting->image_login))
                       <img width="25%"
                            src="{{ asset('storage/' . $setting->image_login) }}" class="mb-4 rounded-circle"
                            alt="Kosong">
                    @endif
                    <h1 class="h4 text-gray-900 mb-4">Verikasi Alamat Email Anda</h1>
                </div>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('Email Verifikasi Baru Telah Berhasil Dikirim Ke Alamat Email Anda.') }}
                    </div>
                @endif

                {{ __('Sebelum meminta pengiriman ulang email verifikasi, silahkan cek terlebih dahulu folder inbox atau spam pada Email Anda.') }}
                {{ __('Jika anda benar-benar tidak menerima Email, Silahkan tekan tombol berikut') }}
                <form class="user mt-4" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit"
                        class="btn btn-primary btn-user btn-block">{{ __('Kirimkan Ulang Email Verifikasi') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
