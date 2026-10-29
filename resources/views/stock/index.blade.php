@extends('layouts.app')

@section('title', 'Transaksi Stok')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Transaksi Stok</h3>
    <a href="{{ route('stock-transactions.create') }}" class="btn btn-primary">+ Catat Transaksi</a>
</div>

<form method="GET" action="{{ route('stock-transactions.index') }}" class="row g-2 mb-3">
    <div class="col-md-4">
        <select name="product_id" class="form-select">
            <option value="">Semua produk</option>
            @foreach ($products as $p)
                <option value="{{ $p->id }}" @selected(request('product_id') == $p->id)>{{ $p->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="type" class="form-select">
            <option value="">Semua jenis</option>
            <option value="in" @selected(request('type') === 'in')>Masuk</option>
            <option value="out" @selected(request('type') === 'out')>Keluar</option>
        </select>
    </div>
    <div class="col-md-3 d-flex gap-2">
        <button class="btn btn-secondary">Filter</button>
        <a href="{{ route('stock-transactions.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Jenis</th>
                    <th class="text-end">Jumlah</th>
                    <th>Catatan</th>
                    <th>Dicatat oleh</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($transactions as $t)
                <tr>
                    <td>{{ $t->transaction_date->format('d/m/Y') }}</td>
                    <td>{{ $t->product->name }}</td>
                    <td>
                        <span class="badge {{ $t->type === 'in' ? 'bg-success' : 'bg-danger' }}">
                            {{ $t->type === 'in' ? 'Masuk' : 'Keluar' }}
                        </span>
                    </td>
                    <td class="text-end">{{ $t->type === 'in' ? '+' : '-' }}{{ $t->quantity }}</td>
                    <td>{{ $t->note ?? '-' }}</td>
                    <td>{{ $t->user->name }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada transaksi.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $transactions->links('pagination::bootstrap-5') }}</div>
@endsection
