{{-- resources/views/admin/units/index.blade.php --}}
@extends('admin.layouts.app')

@section('page-title', 'Manajemen Satuan Unit')

@section('content-admin')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">

            <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Satuan Unit</h1>
                    <p class="mt-2 text-gray-600">Kelola satuan pengukuran bahan baku (kg, gram, liter, pcs, dll)</p>
                </div>

                <a href="{{ route('admin.units.create') }}"
                    class="inline-flex items-center gap-3 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Satuan Baru
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Nama Satuan
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Simbol
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($units as $unit)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-5 text-sm text-gray-500">#{{ $unit->id }}</td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm font-semibold text-gray-900">{{ $unit->name }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-mono font-bold bg-indigo-100 text-indigo-700">
                                            {{ $unit->symbol }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-center text-sm font-medium">
                                        <div class="flex items-center justify-center gap-6">
                                            <a href="{{ route('admin.units.edit', $unit->id) }}"
                                                class="text-indigo-600 hover:text-indigo-800 font-medium">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus satuan «{{ addslashes($unit->name) }}»?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center text-gray-500">
                                        <div
                                            class="mx-auto w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 6h18M3 12h18M3 18h18" />
                                            </svg>
                                        </div>
                                        <p class="text-lg font-medium">Belum ada satuan terdaftar</p>
                                        <p class="mt-1">Tambahkan satuan seperti gram, kg, liter, dll.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($units->hasPages())
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        {{ $units->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection