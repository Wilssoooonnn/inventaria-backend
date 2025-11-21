@extends('admin.layouts.app')

@section('page-title', 'Buat Satuan Baru')

@section('content-admin')
    <a href="{{ route('admin.units.index') }}" class="btn btn-secondary mb-3">Kembali</a>
    <h3>Form Satuan Baru</h3>

    <form action="{{ route('admin.units.store') }}" method="POST" class="mt-4 max-w-lg">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Satuan (cth: Gram):</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            @error('name') <p class="text-danger text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label for="symbol" class="form-label">Simbol Satuan (cth: g):</label>
            <input type="text" name="symbol" id="symbol" class="form-control" value="{{ old('symbol') }}" required>
            @error('symbol') <p class="text-danger text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Satuan</button>
    </form>
@endsection