@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        @yield('page-title', 'Dashboard Inventara F&B')
    </h2>
@endsection


@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="p-4 mb-3 text-sm text-green-700 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="p-4 mb-3 text-sm text-red-700 bg-red-100 rounded-lg">
                    Ada kesalahan validasi pada formulir.
                </div>
            @endif

            {{-- <nav class="mb-4 flex flex-wrap space-x-3 p-3 bg-gray-100 rounded-lg shadow-inner">
                <a href="{{ route('admin.dashboard') }}"
                    class="px-3 py-2 text-sm font-medium text-indigo-600 hover:bg-white rounded-md">Dashboard</a>
                <a href="{{ route('admin.products.index') }}"
                    class="px-3 py-2 text-sm font-medium text-gray-700 hover:bg-white rounded-md">Produk & Menu</a>
                <a href="{{ route('admin.units.index') }}"
                    class="px-3 py-2 text-sm font-medium text-gray-700 hover:bg-white rounded-md">Satuan Unit</a>
                <a href="{{ route('admin.recipes.index') }}"
                    class="px-3 py-2 text-sm font-medium text-gray-700 hover:bg-white rounded-md">Manajemen Resep</a>
            </nav> --}}

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @yield('content-admin')
            </div>
        </div>
    </div>
@endsection