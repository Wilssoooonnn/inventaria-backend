{{-- resources/views/admin/categories/create.blade.php --}}
@extends('admin.layouts.app')

@section('page-title', 'Tambah Kategori Baru')

@section('content-admin')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl mx-auto">

            <!-- Back + Header -->
            <div class="mb-10">
                <a href="{{ route('admin.categories.index') }}"
                    class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Kategori
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Kategori Produk Baru</h1>
                <p class="mt-2 text-gray-600">Contoh: Minuman Kopi, Makanan Ringan, Bahan Baku, Topping, dll</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-8 py-10">
                    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Nama Kategori -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-800 mb-3">
                                Nama Kategori
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200"
                                placeholder="Minuman Kopi, Makanan Berat, Snack, Bahan Baku..." required autofocus>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="pt-8 border-t border-gray-200">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('admin.categories.index') }}"
                                    class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Kategori
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection