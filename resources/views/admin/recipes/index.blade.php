@extends('admin.layouts.app')

@section('page-title', 'Daftar Resep & Komposisi')

@section('content-admin')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold text-gray-800">Daftar Resep F&B</h3>
        <a href="{{ route('admin.recipes.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-150">
            + Buat Resep Baru
        </a>
    </div>

    @if ($recipesGrouped->isEmpty())
        <div class="p-4 text-center text-gray-600 bg-gray-50 rounded-lg border">
            Belum ada resep yang terdaftar. Silakan buat resep untuk Bahan Baku.
        </div>
    @else
        <div class="space-y-6">
            {{-- $recipesGrouped dikirim dari Controller: [MenuName => Collection of Recipes] --}}
            @foreach ($recipesGrouped as $menuName => $recipeGroup)
                <div class="bg-white p-5 rounded-lg shadow-xl border border-gray-100">
                    <h4 class="text-lg font-bold text-indigo-700 mb-3">{{ $menuName }}</h4>

                    <div class="flex justify-between items-center mb-3 border-b pb-2 text-sm text-gray-500">
                        <span>Bahan Baku yang Digunakan:</span>
                        <a href="{{ route('admin.recipes.edit', $recipeGroup->first()->menu->id) }}"
                            class="text-sm text-yellow-600 hover:text-yellow-800">Edit Resep</a>
                    </div>

                    <ul class="list-disc ml-5 space-y-1 text-gray-700">
                        {{-- Loop hanya pada bahan baku untuk menu ini --}}
                        @foreach ($recipeGroup as $recipe)
                            <li class="flex justify-between pr-8">
                                <span>{{ $recipe->ingredient->name }}</span>
                                <span class="font-medium">
                                    {{ number_format($recipe->quantity_used, 4) }}
                                    {{ $recipe->ingredient->unit->symbol ?? 'pcs' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    @endif
@endsection