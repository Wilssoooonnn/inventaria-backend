<x-guest-layout>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-12">

        <!-- Login Card -->
        <div class="w-full max-w-md">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Inventara
                </h1>
                <p class="text-gray-600">
                    Masuk ke dashboard Anda
                </p>
            </div>

            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-gray-900 font-medium mb-2" />
                        <x-text-input id="email"
                            class="block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900 text-base px-4 py-3"
                            type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                            placeholder="nama@perusahaan.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-900 font-medium mb-2" />
                        <x-text-input id="password"
                            class="block w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900 text-base px-4 py-3"
                            type="password" name="password" required autocomplete="current-password"
                            placeholder="Masukkan password Anda" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me + Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-gray-900 focus:ring-gray-900" name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-gray-700 hover:text-gray-900 font-medium"
                                href="{{ route('password.request') }}">
                                {{ __('Lupa password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <x-primary-button
                            class="w-full justify-center py-3 text-base font-semibold rounded-lg bg-gray-900 hover:bg-gray-800 transition duration-200">
                            {{ __('Masuk') }}
                        </x-primary-button>
                    </div>
                </form>

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
    </div>
</x-guest-layout>