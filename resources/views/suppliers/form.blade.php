@extends('layouts.app')

@section('title', $supplier ? 'Edit Supplier' : 'Tambah Supplier')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-3">{{ $supplier ? 'Edit Supplier' : 'Tambah Supplier' }}</h4>

                <form action="{{ $supplier ? route('suppliers.update', $supplier) : route('suppliers.store') }}"
                      method="POST" novalidate>
                    @csrf
                    @if ($supplier)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label class="form-label" for="name">Nama Supplier</label>
                        <input type="text" id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $supplier?->name) }}" autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="phone">Telepon</label>
                        <input type="text" id="phone" name="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $supplier?->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="address">Alamat</label>
                        <textarea id="address" name="address" rows="3"
                                  class="form-control @error('address') is-invalid @enderror">{{ old('address', $supplier?->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
