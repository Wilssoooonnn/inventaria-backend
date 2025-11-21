@extends('admin.layouts.app')

@section('page-title', 'Dashboard Utama Inventara F&B')

@section('content-admin')
    <div class="p-6">
        <h3>Selamat Datang di Dashboard Admin</h3>
        <p class="text-sm text-gray-500">
            Anda login sebagai: {{ Auth::user()->name }} (Role: {{ Auth::user()->role }})
        </p>
        <hr class="my-4">

        <h4>Status Sistem:</h4>
        <div class="mt-4">
            <p><strong>- Total Produk:</strong> [Nanti diisi dengan count dari Model Product]</p>
            <p><strong>- Stok Bahan Baku Kritis:</strong> [Nanti diisi dengan query Low Stock]</p>
        </div>
    </div>
@endsection