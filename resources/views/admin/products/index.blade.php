@extends('admin.layouts.app')

@section('page-title', 'Daftar Produk & Menu')

@section('content-admin')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold text-gray-800">Produk & Menu</h3>
        <a href="{{ route('admin.products.create') }}" 
           class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-150">
            + Tambah Produk Baru
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID / SKU</th>
                    <th class="py-3 px-6 text-left">Nama Produk</th>
                    <th class="py-3 px-6 text-center">Tipe</th>
                    <th class="py-3 px-6 text-center">Satuan</th>
                    <th class="py-3 px-6 text-right">Harga Jual / Beli</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($products as $product)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $product->id }} / <strong class="font-medium">{{ $product->sku }}</strong></td>
                        <td class="py-3 px-6 text-left">{{ $product->name }}</td>
                        <td class="py-3 px-6 text-center">
                            @if ($product->type === 'menu')
                                <span class="bg-indigo-200 text-indigo-600 py-1 px-3 rounded-full text-xs font-semibold">MENU</span>
                            @else
                                <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs font-semibold">BAHAN BAKU</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-center">{{ $product->unit->symbol ?? '-' }}</td>
                        <td class="py-3 px-6 text-right">
                            @if ($product->type === 'menu')
                                Jual: <span class="font-medium text-green-600">Rp{{ number_format($product->sale_price, 0) }}</span>
                            @else
                                Beli: <span class="font-medium text-red-600">Rp{{ number_format($product->purchase_price, 0) }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center space-x-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-yellow-600 hover:text-yellow-900 transition-colors">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus produk {{ $product->name }}? Stok yang terpotong tidak akan kembali.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{-- Link Paginasi --}}
    <div class="mt-6">
        {{ $products->links() }}
    </div>
@endsection