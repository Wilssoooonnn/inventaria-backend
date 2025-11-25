{{-- resources/views/admin/stock/index.blade.php --}}
@extends('admin.layouts.app')

@section('page-title', 'Stok Bahan Baku Tersedia')

@section('content-admin')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        
        <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Stok Bahan Baku</h1>
                <p class="mt-2 text-gray-600">Pantau ketersediaan bahan baku di semua lokasi/gudang</p>
            </div>

            <a href="{{ route('admin.stock.create') }}"
               class="inline-flex items-center gap-3 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4" />
                </svg>
                Penyesuaian Stok
            </a>
        </div>

        
        @if ($stocks->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-16 text-center">
                <div class="mx-auto w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10m0 0l-8-4m8 4l8-4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada stok tercatat</h3>
                <p class="mt-2 text-gray-600">Mulai lakukan penyesuaian stok masuk untuk bahan baku Anda.</p>
            </div>
        @else
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Bahan Baku
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Lokasi / Gudang
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Stok Tersedia
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Stok Minimum
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($stocks as $stock)
                                @php
                                    $product = $stock->product;
                                    $isLow = $stock->quantity <= ($product->stock_minimum ?? 999999);
                                    $statusBadge = $isLow
                                        ? 'bg-red-100 text-red-700 ring-1 ring-red-200'
                                        : 'bg-green-100 text-green-700 ring-1 ring-green-200';
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors duration-150 {{ $isLow ? 'bg-red-50' : '' }}">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                                {{ strtoupper(substr($product->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                                <div class="text-xs text-gray-500">SKU: {{ $product->sku ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-700">
                                        <span class="inline-flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $stock->location->name ?? 'Tidak diketahui' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="text-lg font-bold text-gray-900">
                                            {{ number_format($stock->quantity, 4) }}
                                            <span class="text-sm font-normal text-gray-500">
                                                {{ $product->unit->symbol ?? 'pcs' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-right text-sm text-gray-600">
                                        {{ number_format($product->stock_minimum ?? 0, 0) }}
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold {{ $statusBadge }}">
                                            @if($isLow)
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                                KRITIS
                                            @else
                                                Aman
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                
                @if($stocks->hasPages())
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        {{ $stocks->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection