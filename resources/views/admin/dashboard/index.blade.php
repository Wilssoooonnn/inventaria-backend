@extends('admin.layouts.app')

@section('page-title', 'Dashboard Utama Inventara F&B')

@section('content-admin')
    <div class="space-y-8">

        {{-- ROW 1: KARTU METRIK KUNCI --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Kartu 1: Total Penjualan Hari Ini --}}
            <div class="bg-indigo-50 border-l-4 border-indigo-500 p-5 rounded-lg shadow-md">
                <p class="text-sm font-medium text-indigo-500 uppercase">Penjualan Hari Ini</p>
                {{-- Asumsi $todaySales dilewatkan sebagai float/int --}}
                <p class="text-3xl font-bold text-indigo-900 mt-1">
                    Rp{{ number_format($todaySales ?? 0, 0, ',', '.') }}
                </p>
            </div>

            {{-- Kartu 2: Total Nilai Aset (HPP Stok) --}}
            <div class="bg-teal-50 border-l-4 border-teal-500 p-5 rounded-lg shadow-md">
                <p class="text-sm font-medium text-teal-500 uppercase">Nilai Aset Stok (HPP)</p>
                <p class="text-3xl font-bold text-teal-900 mt-1">
                    Rp{{ number_format($assetValue ?? 0, 0, ',', '.') }}
                </p>
            </div>

            {{-- Kartu 3: Total Produk Terdaftar (Menggunakan query Model langsung) --}}
            <div class="bg-gray-50 border-l-4 border-gray-500 p-5 rounded-lg shadow-md">
                <p class="text-sm font-medium text-gray-500 uppercase">Total Item Master</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">
                    {{ number_format(App\Models\Product::count()) }} Item
                </p>
            </div>
        </div>

        {{-- ROW 2: LOW STOCK & AUDIT LOG --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white p-6 rounded-lg shadow-md border border-red-200">
                <h4 class="text-xl font-semibold text-red-700 mb-4">⚠️ Bahan Baku Kritis</h4>

                {{-- SAFETY CHECK: Cek apakah variabel dikirim dan tidak kosong --}}
                @if (isset($lowStocks) && $lowStocks->isNotEmpty())
                    <ul class="space-y-3">
                        @foreach ($lowStocks as $stock)
                            <li class="flex justify-between border-b pb-2 text-sm">
                                <span>{{ $stock->name }}</span>
                                <span class="font-bold text-red-500">
                                    Sisa: {{ number_format($stock->quantity, 2) }} {{ $stock->unit->symbol ?? 'pcs' }}
                                    (Min: {{ $stock->stock_minimum }})
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('admin.products.index') }}?type=ingredient"
                        class="mt-3 block text-right text-sm text-indigo-500 hover:text-indigo-700">Lihat Semua Stok</a>
                @else
                    <p class="text-green-600">Semua bahan baku dalam batas aman atau belum terdefinisi.</p>
                @endif
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-xl font-semibold text-gray-700 mb-4">Aktivitas Stok Terbaru</h4>

                @if (isset($recentMovements) && $recentMovements->isNotEmpty())
                    <ul class="space-y-3 text-sm">
                        @foreach ($recentMovements as $movement)
                            <li class="flex justify-between border-b pb-2">
                                <span class="text-gray-500 text-xs">{{ $movement->created_at->diffForHumans() }}</span>
                                <span class="font-medium {{ $movement->quantity_change > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $movement->type }}: {{ number_format($movement->quantity_change, 2) }}
                                    {{ $movement->product->unit->symbol ?? 'pcs' }} {{ $movement->product->name }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">Belum ada pergerakan stok tercatat.</p>
                @endif
            </div>
        </div>
    </div>
@endsection