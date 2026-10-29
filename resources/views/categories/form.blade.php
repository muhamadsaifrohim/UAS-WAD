@extends('layouts.app')

@section('title', $category ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-3">{{ $category ? 'Edit Kategori' : 'Tambah Kategori' }}</h4>

                <form action="{{ $category ? route('categories.update', $category) : route('categories.store') }}"
                      method="POST" novalidate>
                    @csrf
                    @if ($category)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label class="form-label" for="name">Nama Kategori</label>
                        <input type="text" id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $category?->name) }}" autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
