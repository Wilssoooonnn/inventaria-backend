<x-guest-layout>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-12">

        <!-- Register Card -->
        <div class="w-full max-w-md">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Inventara
                </h1>
                <p class="text-gray-600">
                    Daftar dan mulai kelola inventaris dengan mudah
                </p>
            </div>

            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-900 font-medium mb-2" />
                        <x-text-input id="name"
                            class="block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900 text-base px-4 py-3"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            placeholder="Masukkan nama lengkap Anda" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-gray-900 font-medium mb-2" />
                        <x-text-input id="email"
                            class="block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900 text-base px-4 py-3"
                            type="email" name="email" :value="old('email')" required autocomplete="username"
                            placeholder="nama@perusahaan.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-900 font-medium mb-2" />
                        <x-text-input id="password"
                            class="block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900 text-base px-4 py-3"
                            type="password" name="password" required autocomplete="new-password"
                            placeholder="Minimal 8 karakter" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')"
                            class="text-gray-900 font-medium mb-2" />
                        <x-text-input id="password_confirmation"
                            class="block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900 text-base px-4 py-3"
                            type="password" name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ketik ulang password Anda" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Terms & Privacy (optional tapi recommended) -->
                    <div class="flex items-start">
                        <input id="terms" type="checkbox" name="terms" required
                            class="mt-1 rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                        <label for="terms" class="ml-3 text-sm text-gray-600">
                            Saya setuju dengan
                            <a href="#" class="font-medium text-gray-900 hover:underline">Syarat & Ketentuan</a> serta
                            <a href="#" class="font-medium text-gray-900 hover:underline">Kebijakan Privasi</a>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('terms')" class="mt-2" />

                    <!-- Submit Button -->
                    <div>
                        <x-primary-button
                            class="w-full justify-center py-3 text-base font-semibold rounded-lg bg-gray-900 hover:bg-gray-800 transition duration-200">
                            {{ __('Daftar Gratis 14 Hari') }}
                        </x-primary-button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Sudah punya akun?</span>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">
                        Masuk ke akun Anda
                        <span class="ml-1">→</span>
                    </a>
                </div>
            </div>

            <!-- Back to Landing -->
            <div class="mt-6 text-center">
                <a href="{{ url('/') }}"
                    class="text-sm text-gray-600 hover:text-gray-900 font-medium inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke beranda
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>