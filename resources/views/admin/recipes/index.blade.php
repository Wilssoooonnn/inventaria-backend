{{-- resources/views/admin/recipes/index.blade.php --}}
@extends('admin.layouts.app')

@section('page-title', 'Daftar Resep F&B')

@section('content-admin')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">

            <!-- Header -->
            <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Daftar Resep F&B</h1>
                    <p class="mt-2 text-gray-600">Kelola resep untuk setiap menu produk jadi</p>
                </div>

                <a href="{{ route('admin.recipes.create') }}"
                    class="inline-flex items-center gap-3 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Resep Baru
                </a>
            </div>

            @if ($recipesGrouped->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-16 text-center">
                    <div class="mx-auto w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada resep terdaftar</h3>
                    <p class="mt-2 text-gray-600">Mulai buat resep untuk menu produk jadi Anda.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($recipesGrouped as $menuName => $recipeGroup)
                        @php
                            $menu = $recipeGroup->first()->menu;
                        @endphp
                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-4">
                                <h3 class="text-lg font-bold">{{ $menuName }}</h3>
                                <p class="text-sm opacity-90">Rp{{ number_format($menu->sale_price ?? 0, 0, ',', '.') }}</p>
                            </div>

                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bahan Baku ({{ $recipeGroup->count() }} item)
                                    </span>
                                    <a href="{{ route('admin.recipes.edit', $menu->id) }}"
                                        class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                        Edit Resep →
                                    </a>
                                </div>

                                <ul class="space-y-3 text-sm">
                                    @foreach ($recipeGroup as $recipe)
                                        <li class="flex justify-between items-center">
                                            <span class="text-gray-700">{{ $recipe->ingredient->name }}</span>
                                            <span class="font-semibold text-gray-900">
                                                {{ number_format($recipe->quantity_used, 4) }}
                                                <span class="text-gray-500 text-xs">
                                                    {{ $recipe->ingredient->unit->symbol ?? 'pcs' }}
                                                </span>
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection