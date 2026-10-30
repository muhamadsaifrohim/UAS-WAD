@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h3 class="mb-1">Halo, {{ auth()->user()->name }} 👋</h3>
        <div class="text-muted small">Ringkasan inventaris gudang · {{ now()->format('d M Y') }}</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('stock-transactions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Catat Transaksi
        </a>
        @if (auth()->user()->isAdmin())
            <a href="{{ route('products.create') }}" class="btn btn-outline-primary">
                <i class="bi bi-box-seam me-1"></i> Tambah Produk
            </a>
        @endif
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon ic-indigo"><i class="bi bi-box-seam"></i></div>
            <div><div class="stat-label">Total Produk</div><div class="stat-value">{{ $totalProducts }}</div></div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon ic-green"><i class="bi bi-stack"></i></div>
            <div><div class="stat-label">Total Stok</div><div class="stat-value">{{ number_format($totalStock) }}</div></div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon ic-amber"><i class="bi bi-tags"></i></div>
            <div><div class="stat-label">Kategori</div><div class="stat-value">{{ $totalCategories }}</div></div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon ic-sky"><i class="bi bi-truck"></i></div>
            <div><div class="stat-label">Supplier</div><div class="stat-value">{{ $totalSuppliers }}</div></div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-exclamation-triangle text-warning me-1"></i> Stok Menipis</span>
                <span class="badge bg-warning-subtle text-warning-emphasis">{{ $lowStock->count() }} produk</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr><th>Produk</th><th>Kategori</th><th class="text-end">Stok</th><th class="text-end">Min</th></tr>
                    </thead>
                    <tbody>
                    @forelse ($lowStock as $p)
                        <tr>
                            <td class="fw-medium">{{ $p->name }}</td>
                            <td class="text-muted">{{ $p->category->name }}</td>
                            <td class="text-end text-danger fw-bold">{{ $p->stock }}</td>
                            <td class="text-end text-muted">{{ $p->min_stock }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">
                            <i class="bi bi-check-circle text-success fs-4 d-block mb-1"></i>Semua stok aman.
                        </td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history text-primary me-1"></i> Transaksi Terakhir</span>
                <a href="{{ route('stock-transactions.index') }}" class="small text-decoration-none">Lihat semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr><th>Tanggal</th><th>Produk</th><th>Jenis</th><th class="text-end">Qty</th><th>Oleh</th></tr>
                    </thead>
                    <tbody>
                    @forelse ($recent as $t)
                        <tr>
                            <td class="text-muted">{{ $t->transaction_date->format('d/m/Y') }}</td>
                            <td class="fw-medium">{{ $t->product->name }}</td>
                            <td>
                                <span class="badge {{ $t->type === 'in' ? 'bg-success-subtle text-success-emphasis' : 'bg-danger-subtle text-danger-emphasis' }}">
                                    <i class="bi {{ $t->type === 'in' ? 'bi-arrow-down-short' : 'bi-arrow-up-short' }}"></i>
                                    {{ $t->type === 'in' ? 'Masuk' : 'Keluar' }}
                                </span>
                            </td>
                            <td class="text-end">{{ $t->quantity }}</td>
                            <td class="text-muted">{{ $t->user->name }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada transaksi.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
