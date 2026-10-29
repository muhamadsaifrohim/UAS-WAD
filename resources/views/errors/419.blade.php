@extends('layouts.app')

@section('title', '419 - Sesi Kedaluwarsa')

@section('content')
<div class="text-center mt-5">
    <div class="display-1 fw-bold text-secondary">419</div>
    <h3 class="mb-3">Sesi Kedaluwarsa</h3>
    <p class="text-muted">Sesi Anda telah berakhir. Silakan muat ulang halaman lalu coba lagi.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection
