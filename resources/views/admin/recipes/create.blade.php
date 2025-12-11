{{-- resources/views/admin/recipes/create.blade.php --}}
@extends('admin.layouts.app')

@section('page-title', 'Buat Resep Baru')

@section('content-admin')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">

            <!-- Header -->
            <div class="mb-10">
                <a href="{{ route('admin.recipes.index') }}"
                    class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Resep
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Buat Resep Baru</h1>
                <p class="mt-2 text-gray-600">Tentukan bahan baku dan jumlah yang digunakan untuk satu porsi menu.</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-8 py-10">
                    <form action="{{ route('admin.recipes.store') }}" method="POST">
                        @csrf

                        <!-- Pilih Menu -->
                        <div class="mb-8">
                            <label for="menu_id" class="block text-sm font-semibold text-gray-800 mb-3">
                                Menu Produk Jadi
                            </label>
                            <select name="menu_id" id="menu_id" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200">
                                <option value="">Pilih menu produk jadi...</option>
                                @foreach ($menu_items as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }} — Rp{{ number_format($item->sale_price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('menu_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <hr class="my-10 border-gray-200">

                        <!-- Daftar Bahan Baku -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-bold text-gray-900">Bahan Baku yang Digunakan</h3>
                                <button type="button" id="add-ingredient"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah Bahan
                                </button>
                            </div>

                            <div id="ingredients-container" class="space-y-4">
                                <!-- Row akan ditambahkan via JS -->
                            </div>

                            @error('ingredients')
                                <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="pt-8 border-t border-gray-200">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('admin.recipes.index') }}"
                                    class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Resep
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('ingredients-container');
            let index = 0;

            function createRow() {
                const row = document.createElement('div');
                row.className = 'grid grid-cols-1 md:grid-cols-3 gap-4 items-start border border-gray-200 rounded-lg p-4 bg-gray-50';

                row.innerHTML = `
                <div>
                    <select name="ingredients[${index}][ingredient_id]" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all">
                        <option value="">Pilih bahan baku...</option>
                        @foreach ($ingredients as $ing)
                            <option value="{{ $ing->id }}">
                                {{ $ing->name }} ({{ $ing->unit->symbol ?? 'pcs' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <input type="number" step="0.0001" name="ingredients[${index}][quantity_used]"
                           placeholder="0.150" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all">
                </div>
                <div class="flex items-center justify-end">
                    <button type="button" class="remove-row text-red-600 hover:text-red-800 font-medium">
                        Hapus
                    </button>
                </div>
            `;

                container.appendChild(row);
                index++;
            }

            document.getElementById('add-ingredient').addEventListener('click', createRow);

            container.addEventListener('click', function (e) {
                if (e.target && e.target.classList.contains('remove-row')) {
                    e.target.closest('div.border').remove();
                }
            });

            // Tambah 1 baris otomatis saat load
            createRow();
        });
    </script>
@endsection