@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div class="text-center mt-5">
    <div class="display-1 fw-bold text-secondary">404</div>
    <h3 class="mb-3">Halaman Tidak Ditemukan</h3>
    <p class="text-muted">Halaman yang Anda cari tidak ada atau sudah dipindahkan.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection
