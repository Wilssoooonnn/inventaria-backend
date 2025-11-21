@extends('admin.layouts.app')

@section('page-title', 'Buat Produk F&B Baru')

@section('content-admin')
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('admin.products.index') }}" class="text-indigo-600 hover:text-indigo-900 mb-4 inline-block">&larr;
            Kembali ke Daftar</a>
        <h3 class="text-2xl font-bold mb-6">Form Produk Baru</h3>

        <form action="{{ route('admin.products.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            {{-- 1. PILIH TIPE PRODUK (Kunci Percabangan) --}}
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Tipe Produk:</label>
                <select name="type" id="product_type"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="menu" {{ old('type') == 'menu' ? 'selected' : '' }}>Menu (Dijual)</option>
                    <option value="ingredient" {{ old('type') == 'ingredient' ? 'selected' : '' }}>Bahan Baku (Dilacak Stok)
                    </option>
                </select>
                @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- 2. FIELD DASAR --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk:</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    value="{{ old('name') }}" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori:</label>
                <select name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <hr class="my-6">

            {{-- 3. FIELD KHUSUS MENU (Tampil jika type=menu) --}}
            <div id="menu_fields" class="p-4 bg-indigo-50 border border-indigo-200 rounded-lg" style="display: none;">
                <h4 class="font-semibold mb-3 text-indigo-800">Pengaturan Menu (Dijual)</h4>
                <div class="mb-4">
                    <label for="sale_price" class="block text-sm font-medium text-gray-700">Harga Jual (Rp):</label>
                    <input type="number" step="1" name="sale_price" id="sale_price"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('sale_price') }}">
                    @error('sale_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- 4. FIELD KHUSUS BAHAN BAKU (Tampil jika type=ingredient) --}}
            <div id="ingredient_fields" class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg" style="display: none;">
                <h4 class="font-semibold mb-3 text-yellow-800">Pengaturan Bahan Baku (Stok)</h4>
                <div class="mb-4">
                    <label for="sku" class="block text-sm font-medium text-gray-700">SKU/Barcode (Wajib):</label>
                    <input type="text" name="sku" id="sku_ingredient"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('sku') }}">
                    @error('sku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="unit_id" class="block text-sm font-medium text-gray-700">Satuan Unit (g/kg/ml):</label>
                    <select name="unit_id" id="unit_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Pilih Satuan...</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                {{ $unit->name }} ({{ $unit->symbol }})
                            </option>
                        @endforeach
                    </select>
                    @error('unit_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="purchase_price" class="block text-sm font-medium text-gray-700">Harga Beli/Modal
                        (Rp):</label>
                    <input type="number" step="1" name="purchase_price" id="purchase_price"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('purchase_price') }}">
                    @error('purchase_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="stock_minimum" class="block text-sm font-medium text-gray-700">Stok Minimum (Alert):</label>
                    <input type="number" step="1" name="stock_minimum" id="stock_minimum"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('stock_minimum') }}">
                    @error('stock_minimum') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-150 mt-4">Simpan
                Produk</button>
        </form>

        {{-- LOGIKA JAVASCRIPT UNTUK TOGGLE FIELD BERDASARKAN TIPE --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const typeSelect = document.getElementById('product_type');
                const menuFields = document.getElementById('menu_fields');
                const ingredientFields = document.getElementById('ingredient_fields');

                // Dapatkan input SKU untuk diatur namanya (hanya satu yang aktif)
                const skuIngredient = document.getElementById('sku_ingredient');

                function toggleFields(type) {
                    // Atur visibility
                    menuFields.style.display = type === 'menu' ? 'block' : 'none';
                    ingredientFields.style.display = type === 'ingredient' ? 'block' : 'none';

                    // Atur atribut 'name' agar hanya field yang terlihat yang divalidasi/dikirim
                    if (type === 'ingredient') {
                        skuIngredient.name = 'sku'; // Aktifkan SKU untuk Ingredient
                    } else if (type === 'menu') {
                        skuIngredient.name = ''; // Nonaktifkan SKU untuk Ingredient
                    } else {
                        skuIngredient.name = ''; // Nonaktifkan jika belum memilih
                    }
                }

                // Panggil saat halaman dimuat (untuk old input)
                toggleFields(typeSelect.value);

                // Panggil saat nilai dropdown berubah
                typeSelect.addEventListener('change', function () {
                    toggleFields(typeSelect.value);
                });
            });
        </script>
    </div>
@endsection