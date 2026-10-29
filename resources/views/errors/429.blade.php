@extends('layouts.app')

@section('title', '429 - Terlalu Banyak Percobaan')

@section('content')
<div class="text-center mt-5">
    <div class="display-1 fw-bold text-secondary">429</div>
    <h3 class="mb-3">Terlalu Banyak Percobaan</h3>
    <p class="text-muted">Anda terlalu sering mencoba. Tunggu sebentar lalu coba lagi.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection
