@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-wrap">

    <div class="auth-hero d-none d-lg-flex">
        <div class="logo"><i class="bi bi-box-seam-fill"></i></div>
        <h1>Sistem Manajemen<br>Inventaris Gudang</h1>
        <p>Kelola produk, pantau stok, dan catat barang masuk serta keluar dalam satu tempat.</p>
        <ul>
            <li><i class="bi bi-box-seam"></i> Data produk, kategori, dan supplier</li>
            <li><i class="bi bi-arrow-left-right"></i> Pencatatan stok masuk dan keluar</li>
            <li><i class="bi bi-bell"></i> Peringatan stok menipis</li>
            <li><i class="bi bi-shield-lock"></i> Akses berdasarkan peran pengguna</li>
        </ul>
    </div>

    <div class="auth-form">
        <div class="auth-box">
            <h2 class="mb-1">Selamat datang 👋</h2>
            <p class="text-muted mb-4">Silakan login untuk melanjutkan.</p>

            <form action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="nama@email.com" autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>

                <button class="btn btn-primary w-100 py-2">Login</button>
            </form>

            <p class="text-center text-muted mt-4 mb-0">
                Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Daftar</a>
            </p>
        </div>
    </div>
</div>
@endsection
