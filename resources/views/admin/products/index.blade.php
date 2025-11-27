{{-- resources/views/admin/products/index.blade.php --}}
@extends('admin.layouts.app')

@section('page-title', 'Daftar Produk & Menu')

@section('content-admin')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Produk & Menu F&B</h1>
                <p class="mt-2 text-gray-600">Kelola semua menu yang dijual dan bahan baku yang dilacak stoknya</p>
            </div>

            <a href="{{ route('admin.products.create') }}"
               class="inline-flex items-center gap-3 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk Baru
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID / SKU</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Produk</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipe</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Satuan</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-5 text-sm">
                                    <div class="font-mono text-gray-500">#{{ $product->id }}</div>
                                    @if($product->sku)
                                        <div class="font-medium text-gray-900">{{ $product->sku }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                    @if($product->category)
                                        <div class="text-xs text-gray-500">{{ $product->category->name }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if($product->type === 'menu')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">
                                            MENU
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                            BAHAN BAKU
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center text-sm text-gray-700">
                                    {{ $product->unit?->symbol ?? '—' }}
                                </td>
                                <td class="px-6 py-5 text-right">
                                    @if($product->type === 'menu')
                                        <div class="text-green-600 font-bold">
                                            Rp{{ number_format($product->sale_price, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-gray-500">Harga Jual</div>
                                    @else
                                        <div class="text-red-600 font-bold">
                                            Rp{{ number_format($product->purchase_price ?? 0, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-gray-500">Harga Beli</div>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-5">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                           class="text-indigo-600 hover:text-indigo-800 font-medium">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}"
                                              method="POST" class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus «{{ addslashes($product->name) }}»? Stok tidak akan kembali.');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-800 font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                                    <div class="mx-auto w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                    </div>
                                    <p class="text-lg font-medium">Belum ada produk terdaftar</p>
                                    <p class="mt-1">Tambahkan menu atau bahan baku pertama Anda.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection