@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h3 class="mb-4">Dashboard</h3>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card text-center shadow-sm"><div class="card-body">
            <div class="text-muted">Total Produk</div>
            <div class="fs-2 fw-bold">{{ $totalProducts }}</div>
        </div></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center shadow-sm"><div class="card-body">
            <div class="text-muted">Total Stok</div>
            <div class="fs-2 fw-bold">{{ number_format($totalStock) }}</div>
        </div></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center shadow-sm"><div class="card-body">
            <div class="text-muted">Kategori</div>
            <div class="fs-2 fw-bold">{{ $totalCategories }}</div>
        </div></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center shadow-sm"><div class="card-body">
            <div class="text-muted">Supplier</div>
            <div class="fs-2 fw-bold">{{ $totalSuppliers }}</div>
        </div></div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-warning-subtle fw-semibold">⚠️ Stok Menipis</div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Produk</th><th>Kategori</th><th class="text-end">Stok</th><th class="text-end">Min</th></tr></thead>
                    <tbody>
                    @forelse ($lowStock as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->category->name }}</td>
                            <td class="text-end text-danger fw-bold">{{ $p->stock }}</td>
                            <td class="text-end">{{ $p->min_stock }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Semua stok aman.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold">🕘 Transaksi Terakhir</div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Tanggal</th><th>Produk</th><th>Jenis</th><th class="text-end">Qty</th><th>Oleh</th></tr></thead>
                    <tbody>
                    @forelse ($recent as $t)
                        <tr>
                            <td>{{ $t->transaction_date->format('d/m/Y') }}</td>
                            <td>{{ $t->product->name }}</td>
                            <td>
                                <span class="badge {{ $t->type === 'in' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $t->type === 'in' ? 'Masuk' : 'Keluar' }}
                                </span>
                            </td>
                            <td class="text-end">{{ $t->quantity }}</td>
                            <td>{{ $t->user->name }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">Belum ada transaksi.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
