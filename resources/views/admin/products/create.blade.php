{{-- resources/views/admin/products/create.blade.php --}}
@extends('admin.layouts.app')

@section('page-title', 'Tambah Produk / Menu Baru')

@section('content-admin')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">

            <div class="mb-10">
                <a href="{{ route('admin.products.index') }}"
                    class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Produk
                </a>

                <h1 class="text-3xl font-bold text-gray-900">Tambah Produk / Menu Baru</h1>
                <p class="mt-2 text-gray-600">Pilih tipe produk terlebih dahulu untuk menampilkan form yang sesuai</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-8 py-10">
                    <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <div>
                            <label for="product_type" class="block text-sm font-semibold text-gray-800 mb-3">
                                Tipe Produk
                            </label>

                            <select name="type" id="product_type" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200">
                                <option value="">-- Pilih Tipe Produk --</option>
                                <option value="menu" {{ old('type') === 'menu' ? 'selected' : '' }}>Menu (Produk Jadi)
                                </option>
                                <option value="ingredient" {{ old('type') === 'ingredient' ? 'selected' : '' }}>Bahan Baku
                                </option>
                            </select>

                            @error('type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-800 mb-3">Nama Produk</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                    placeholder="Es Kopi Susu Gula Aren">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id"
                                    class="block text-sm font-semibold text-gray-800 mb-3">Kategori</label>
                                <select name="category_id" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

                                    <option value="">Pilih kategori...</option>

                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('category_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-10 border-gray-200">

                        <div id="menu_fields" class="space-y-6 bg-indigo-50/50 border border-indigo-200 rounded-xl p-6"
                            style="display: none;">
                            <h3 class="text-lg font-bold text-indigo-800">Pengaturan Menu (Dijual)</h3>

                            <div>
                                <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Harga Jual (Rp)
                                </label>

                                <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                    placeholder="25000">

                                @error('sale_price')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="ingredient_fields" class="space-y-6 bg-amber-50/50 border border-amber-200 rounded-xl p-6"
                            style="display: none;">
                            <h3 class="text-lg font-bold text-amber-800">Pengaturan Bahan Baku (Stok)</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU /
                                        Barcode</label>
                                    <input type="text" name="sku" id="sku" value="{{ old('sku') }}"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                        placeholder="KOPI-001">
                                    @error('sku')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="unit_id" class="block text-sm font-medium text-gray-700 mb-2">Satuan
                                        Unit</label>
                                    <select name="unit_id" id="unit_id"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                                        <option value="">Pilih satuan...</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->name }} ({{ $unit->symbol }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga Beli (Rp)</label>
                                    <input type="number" name="purchase_price" value="{{ old('purchase_price') }}"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                        placeholder="150000">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok Minimum</label>
                                    <input type="number" name="stock_minimum" value="{{ old('stock_minimum', 10) }}"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                        placeholder="10">
                                </div>
                            </div>
                        </div>

                        <div class="pt-8 border-t border-gray-200">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('admin.products.index') }}"
                                    class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                                    Batal
                                </a>

                                <button type="submit"
                                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Produk
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const typeSelect = document.getElementById('product_type');
                const menuFields = document.getElementById('menu_fields');
                const ingredientFields = document.getElementById('ingredient_fields');

                function toggleFields() {
                    const type = typeSelect.value;
                    menuFields.style.display = type === 'menu' ? 'block' : 'none';
                    ingredientFields.style.display = type === 'ingredient' ? 'block' : 'none';
                }

                typeSelect.addEventListener('change', toggleFields);
                toggleFields(); 
            });
        </script>
    </div>
@endsection