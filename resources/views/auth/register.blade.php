@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="auth-wrap">

    <div class="auth-hero d-none d-lg-flex">
        <div class="logo"><i class="bi bi-box-seam-fill"></i></div>
        <h1>Bergabung dan<br>mulai kelola stok</h1>
        <p>Buat akun staff untuk melihat produk dan mencatat transaksi stok gudang.</p>
        <ul>
            <li><i class="bi bi-person-check"></i> Akun baru otomatis berperan staff</li>
            <li><i class="bi bi-arrow-left-right"></i> Catat barang masuk dan keluar</li>
            <li><i class="bi bi-shield-lock"></i> Data dilindungi dengan password terenkripsi</li>
        </ul>
    </div>

    <div class="auth-form">
        <div class="auth-box">
            <h2 class="mb-1">Buat akun baru</h2>
            <p class="text-muted mb-4">Lengkapi data berikut untuk mendaftar.</p>

            <form action="{{ route('register') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="name">Nama</label>
                    <input type="text" id="name" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password"
                           class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                </div>

                <button class="btn btn-primary w-100 py-2">Daftar</button>
            </form>

            <p class="text-center text-muted mt-4 mb-0">
                Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Login</a>
            </p>
        </div>
    </div>
</div>
@endsection
