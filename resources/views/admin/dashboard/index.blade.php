@extends('admin.layouts.app')

@section('page-title', 'Dashboard Utama Inventara F&B')

@section('content-admin')
    <div class="space-y-10">

        {{-- TITLE --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Analitik</h1>
            <p class="text-gray-500 text-sm">Ringkasan performa operasional & inventori hari ini</p>
        </div>

        {{-- ROW 1 — ANALYTICS CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Card: Penjualan Hari Ini --}}
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                <p class="text-xs font-semibold text-gray-500 uppercase">Penjualan Hari Ini</p>

                <h3 class="text-3xl font-bold text-gray-900 mt-2">
                    Rp{{ number_format($todaySales ?? 0, 0, ',', '.') }}
                </h3>

                {{-- Insight Tren Penjualan --}}
                @php
                    $salesChange = $salesChange ?? null; // contoh variabel opsional
                @endphp

                <p class="mt-2 text-sm {{ ($salesChange ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    @if(isset($salesChange))
                        {{ $salesChange >= 0 ? '▲' : '▼' }}
                        {{ number_format(abs($salesChange), 1) }}% dibanding kemarin
                    @else
                        <span class="text-gray-400 italic">Data tren tidak tersedia</span>
                    @endif
                </p>
            </div>

            {{-- Card: Nilai Aset Stok --}}
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                <p class="text-xs font-semibold text-gray-500 uppercase">Total Nilai Aset (HPP)</p>

                <h3 class="text-3xl font-bold text-gray-900 mt-2">
                    Rp{{ number_format($assetValue ?? 0, 0, ',', '.') }}
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Perhitungan berdasarkan nilai HPP terkini pada semua bahan baku.
                </p>
            </div>

            {{-- Card: Total Produk Terdaftar --}}
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                <p class="text-xs font-semibold text-gray-500 uppercase">Total Item Master</p>

                <h3 class="text-3xl font-bold text-gray-900 mt-2">
                    {{ number_format(App\Models\Product::count()) }} Item
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Termasuk bahan baku, produk olahan, dan kategori lainnya.
                </p>
            </div>
        </div>

        {{-- ROW 2 — LOW STOCK TABLE & RECENT ACTIVITY --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- LOW STOCK TABLE (Analytic Style) --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-red-100 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-red-700">Bahan Baku Kritis</h4>
                    <span class="text-xs bg-red-50 text-red-600 px-2 py-1 rounded">Inventory Alert</span>
                </div>

                @if ($lowStocks->isNotEmpty())
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 text-xs border-b">
                                <th class="py-2">Nama</th>
                                <th class="py-2 text-right">Sisa</th>
                                <th class="py-2 text-right">Min</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($lowStocks as $stock)
                                <tr class="border-b">

                                    {{-- Nama Produk --}}
                                    <td class="py-2 font-medium text-gray-700">
                                        {{ $stock->product->name }}
                                    </td>

                                    {{-- Sisa Stok --}}
                                    <td class="py-2 text-right font-semibold text-red-600">
                                        {{ number_format($stock->quantity, 2) }}
                                        {{ $stock->product->unit->symbol ?? 'pcs' }}
                                    </td>

                                    {{-- Minimum Stok --}}
                                    <td class="py-2 text-right text-gray-600">
                                        {{ $stock->product->stock_minimum }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-green-600">Tidak ada stok kritis saat ini.</p>
                @endif
            </div>

            {{-- RECENT MOVEMENTS (Timeline Analytic Style) --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Stok Terbaru</h4>

                @if (isset($recentMovements) && $recentMovements->isNotEmpty())
                    <ul class="space-y-4 text-sm">
                        @foreach ($recentMovements as $movement)
                            <li
                                class="relative pl-6 border-l {{ $movement->quantity_change > 0 ? 'border-green-300' : 'border-red-300' }}">
                                <div
                                    class="absolute left-[-6px] top-1 w-3 h-3 rounded-full 
                                                                                                                                                {{ $movement->quantity_change > 0 ? 'bg-green-500' : 'bg-red-500' }}">
                                </div>

                                <p class="text-xs text-gray-400">{{ $movement->created_at->diffForHumans() }}</p>

                                <p class="font-medium {{ $movement->quantity_change > 0 ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $movement->type }}:
                                    {{ number_format($movement->quantity_change, 2) }}
                                    {{ $movement->product->unit->symbol ?? 'pcs' }} —
                                    {{ $movement->product->name }}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">Belum ada aktivitas stok dalam beberapa waktu.</p>
                @endif
            </div>

        </div>
    </div>
@endsection