{{-- resources/views/admin/stock/create.blade.php --}}
@extends('admin.layouts.app')

@section('page-title', 'Penyesuaian Stok Bahan Baku')

@section('content-admin')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">

            <div class="mb-10">
                <a href="{{ route('admin.stock.index') }}"
                    class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Stok
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Penyesuaian Stok Bahan Baku</h1>
                <p class="mt-2 text-gray-600">Tambah stok dari supplier, koreksi audit, atau catat pembuangan/rusak</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-8 py-10">
                    <form id="stockAdjustmentForm" action="#" method="POST" class="space-y-8">
                        @csrf

                        <div id="form-status" class="hidden py-4 px-6 rounded-lg text-sm font-medium"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="product_id" class="block text-sm font-semibold text-gray-800 mb-3">
                                    Bahan Baku / Ingredient
                                </label>
                                <select name="product_id" id="product_id" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200">
                                    <option value="">Pilih bahan baku...</option>
                                    @foreach ($ingredients as $ingredient)
                                        <option value="{{ $ingredient->id }}"
                                            data-unit="{{ $ingredient->unit->symbol ?? 'pcs' }}"
                                            data-sku="{{ $ingredient->sku ?? '' }}">
                                            {{ $ingredient->name }}
                                            @if($ingredient->sku)({{ $ingredient->sku }})@endif
                                            — {{ $ingredient->unit->symbol ?? 'pcs' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="location_id" class="block text-sm font-semibold text-gray-800 mb-3">
                                    Lokasi / Gudang
                                </label>
                                <select name="location_id" id="location_id" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200">
                                    <option value="">Pilih lokasi...</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="type" class="block text-sm font-semibold text-gray-800 mb-3">
                                    Tipe Pergerakan Stok
                                </label>
                                <select name="type" id="type" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200">
                                    <option value="inbound">Barang Masuk (dari Supplier)</option>
                                    <option value="adjustment">Penyesuaian Tambah (Audit/Stok Opname)</option>
                                    <option value="outbound_waste">Barang Keluar (Rusak / Waste)</option>
                                </select>
                            </div>

                            <div>
                                <label for="quantity_change" class="block text-sm font-semibold text-gray-800 mb-3">
                                    Kuantitas Perubahan
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.0001" name="quantity_change" id="quantity_change"
                                        placeholder="10.5000" required
                                        class="w-full pl-4 pr-20 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200">
                                    <span id="unit_display"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1 bg-gray-100 text-gray-700 font-medium text-sm rounded-md">
                                        pcs
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="remarks" class="block text-sm font-semibold text-gray-800 mb-3">
                                Catatan / Keterangan <span class="text-gray-500 font-normal text-xs">(opsional)</span>
                            </label>
                            <textarea name="remarks" id="remarks" rows="3"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 resize-none transition-all duration-200"
                                placeholder="Contoh: Terima dari supplier PT Maju Jaya, faktur #INV-2025-089"></textarea>
                        </div>

                        <div class="pt-8 border-t border-gray-200">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('admin.stock.index') }}"
                                    class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Proses Penyesuaian Stok
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
            const form = document.getElementById('stockAdjustmentForm');
            const unitDisplay = document.getElementById('unit_display');
            const productSelect = document.getElementById('product_id');
            const formStatus = document.getElementById('form-status');

            function updateUnitDisplay() {
                const selected = productSelect.options[productSelect.selectedIndex];
                const unit = selected?.getAttribute('data-unit') || 'pcs';
                unitDisplay.textContent = unit;
            }
            productSelect.addEventListener('change', updateUnitDisplay);
            updateUnitDisplay();
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                formStatus.style.display = 'none';

                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());

                fetch('/api/stock-adjustments', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    credentials: 'include',
                    body: JSON.stringify(data)
                })
                    .then(r => {
                        if (!r.ok) {
                            if (r.status === 422) return r.json().then(err => { throw new Error(Object.values(err.errors).flat().join(', ')); });
                            if (r.status === 403) throw new Error('Akses ditolak. Pastikan login sebagai Admin.');
                            throw new Error(`Server error: ${r.status}`);
                        }
                        return r.json();
                    })
                    .then(res => {
                        formStatus.className = 'bg-green-100 text-green-700 border border-green-200';
                        formStatus.textContent = `Sukses! Stok sekarang: ${res.current_stock} ${res.unit}`;
                        formStatus.style.display = 'block';
                        form.reset();
                        updateUnitDisplay();
                    })
                    .catch(err => {
                        formStatus.className = 'bg-red-100 text-red-700 border border-red-200';
                        formStatus.textContent = 'Gagal: ' + err.message;
                        formStatus.style.display = 'block';
                    });
            });
        });
    </script>
@endsection