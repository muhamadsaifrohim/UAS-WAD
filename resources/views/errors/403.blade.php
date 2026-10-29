@extends('layouts.app')

@section('title', '403 - Akses Ditolak')

@section('content')
<div class="text-center mt-5">
    <div class="display-1 fw-bold text-secondary">403</div>
    <h3 class="mb-3">Akses Ditolak</h3>
    <p class="text-muted">Anda tidak memiliki izin untuk membuka halaman ini.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection
