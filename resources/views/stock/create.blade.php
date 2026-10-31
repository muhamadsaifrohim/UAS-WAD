@extends('layouts.app')

@section('title', 'Catat Transaksi Stok')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-3">Catat Transaksi Stok</h4>

                <form action="{{ route('stock-transactions.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="product_id">Produk</label>
                        <select id="product_id" name="product_id"
                                class="form-select @error('product_id') is-invalid @enderror">
                            <option value="">-- Pilih produk --</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}"
                                    @selected(old('product_id', $selectedProduct) == $p->id)>
                                    {{ $p->name }} (stok: {{ $p->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Jenis Transaksi</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="type_in" value="in"
                                   @checked(old('type', 'in') === 'in')>
                            <label class="form-check-label" for="type_in">Barang Masuk</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="type_out" value="out"
                                   @checked(old('type') === 'out')>
                            <label class="form-check-label" for="type_out">Barang Keluar</label>
                        </div>
                        @error('type')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="quantity">Jumlah</label>
                            <input type="number" id="quantity" name="quantity" min="1"
                                   class="form-control @error('quantity') is-invalid @enderror"
                                   value="{{ old('quantity') }}">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="transaction_date">Tanggal</label>
                            <input type="date" id="transaction_date" name="transaction_date"
                                   class="form-control @error('transaction_date') is-invalid @enderror"
                                   value="{{ old('transaction_date', now()->toDateString()) }}">
                            @error('transaction_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="note">Catatan (opsional)</label>
                        <input type="text" id="note" name="note"
                               class="form-control @error('note') is-invalid @enderror"
                               value="{{ old('note') }}">
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('stock-transactions.index') }}" class="btn btn-outline-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
