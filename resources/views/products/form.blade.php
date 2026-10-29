@extends('layouts.app')

@section('title', $product ? 'Edit Produk' : 'Tambah Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-3">{{ $product ? 'Edit Produk' : 'Tambah Produk' }}</h4>

                <form action="{{ $product ? route('products.update', $product) : route('products.store') }}"
                      method="POST" novalidate>
                    @csrf
                    @if ($product)
                        @method('PUT')
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="category_id">Kategori</label>
                            <select id="category_id" name="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">-- Pilih kategori --</option>
                                @foreach ($categories as $c)
                                    <option value="{{ $c->id }}"
                                        @selected(old('category_id', $product?->category_id) == $c->id)>{{ $c->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="supplier_id">Supplier</label>
                            <select id="supplier_id" name="supplier_id"
                                    class="form-select @error('supplier_id') is-invalid @enderror">
                                <option value="">-- Pilih supplier --</option>
                                @foreach ($suppliers as $s)
                                    <option value="{{ $s->id }}"
                                        @selected(old('supplier_id', $product?->supplier_id) == $s->id)>{{ $s->name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="sku">SKU</label>
                            <input type="text" id="sku" name="sku"
                                   class="form-control @error('sku') is-invalid @enderror"
                                   value="{{ old('sku', $product?->sku) }}">
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-8 mb-3">
                            <label class="form-label" for="name">Nama Produk</label>
                            <input type="text" id="name" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $product?->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="price">Harga (Rp)</label>
                            <input type="number" id="price" name="price" min="0"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $product?->price) }}">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="min_stock">Stok Minimum</label>
                            <input type="number" id="min_stock" name="min_stock" min="0"
                                   class="form-control @error('min_stock') is-invalid @enderror"
                                   value="{{ old('min_stock', $product?->min_stock ?? 5) }}">
                            @error('min_stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-text mb-3">
                        Stok tidak diisi di sini. Stok berubah lewat transaksi barang masuk/keluar.
                    </div>

                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
