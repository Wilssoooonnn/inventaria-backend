{{-- resources/views/admin/users/create.blade.php --}}
@extends('admin.layouts.app')

@section('page-title', 'Buat User Baru')

@section('content-admin')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">

            <!-- Header + Back Button -->
            <div class="mb-10">
                <a href="{{ route('admin.users.index') }}"
                    class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200 mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Daftar User
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Buat User Baru</h1>
                <p class="mt-2 text-gray-600">Isi data user dengan lengkap dan benar.</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-8 py-10">

                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-7">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-800 mb-2">
                                Nama Lengkap
                            </label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 outline-none text-gray-900 placeholder-gray-400"
                                placeholder="Contoh: Budi Santoso" required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-800 mb-2">
                                Email
                            </label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 outline-none text-gray-900 placeholder-gray-400"
                                placeholder="budi@perusahaan.com" required>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-800 mb-2">
                                Password
                                <span class="text-xs font-normal text-gray-500">(minimal 8 karakter)</span>
                            </label>
                            <input type="password" name="password" id="password"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 outline-none text-gray-900"
                                placeholder="••••••••" required>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-sm font-semibold text-gray-800 mb-2">
                                Peran (Role)
                            </label>
                            <select name="role" id="role"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 outline-none text-gray-900"
                                required>
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih peran</option>
                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff (Mobile PoS)</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Web Dashboard)</option>
                            </select>
                            @error('role')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lokasi Tugas -->
                        <div>
                            <label for="location_id" class="block text-sm font-semibold text-gray-800 mb-2">
                                Lokasi Tugas
                            </label>
                            <select name="location_id" id="location_id"
                                class="w-full px-4  py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 outline-none text-gray-900"
                                required>
                                <option value="" disabled {{ old('location_id') ? '' : 'selected' }}>Pilih lokasi tugas</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('admin.users.index') }}"
                                    class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors duration-200">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection