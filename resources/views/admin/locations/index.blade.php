{{-- resources/views/admin/locations/index.blade.php --}}
@extends('admin.layouts.app')

@section('page-title', 'Manajemen Lokasi & Gudang')

@section('content-admin')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">

            <!-- Header -->
            <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Manajemen Lokasi & Gudang</h1>
                    <p class="mt-2 text-gray-600">Kelola semua cabang, gudang, dan outlet di sini</p>
                </div>

                <a href="{{ route('admin.locations.create') }}"
                    class="inline-flex items-center gap-3 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Lokasi Baru
                </a>
            </div>

            <!-- Table Card -->
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
                                    Nama Lokasi
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Alamat
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($locations as $location)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-5 text-sm text-gray-500">
                                        #{{ $location->id }}
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                                {{ strtoupper(substr($location->name, 0, 2)) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">{{ $location->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-700">
                                        {{ $location->address ?? '— Tidak ada alamat' }}
                                    </td>
                                    <td class="px-6 py-5 text-center text-sm font-medium">
                                        <div class="flex items-center justify-center gap-6">
                                            <a href="{{ route('admin.locations.edit', $location->id) }}"
                                                class="text-indigo-600 hover:text-indigo-800 font-medium">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.locations.destroy', $location->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus lokasi «{{ addslashes($location->name) }}»?');">
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
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <p class="text-lg font-medium">Belum ada lokasi terdaftar</p>
                                        <p class="mt-1">Tambahkan gudang atau cabang pertama Anda sekarang.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(method_exists($locations, 'links'))
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        {{ $locations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection