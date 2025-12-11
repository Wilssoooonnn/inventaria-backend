<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">

        <div class="flex items-center space-x-6">

            <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                <img src="{{ asset('assets/logo.svg') }}" alt="Logo" class="h-9 w-auto"> </a>
            <nav class="hidden sm:flex items-center space-x-6">

                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    Dashboard
                </x-nav-link>

                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 transition">
                            <span>Master Data</span>
                            <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.7-3.71a.75.75 0 111.08 1.04l-4.24 4.25a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('admin.products.index')">
                            Produk & Menu
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('admin.units.index')">
                            Satuan Unit
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('admin.categories.index')">
                            Kategori
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('admin.locations.index')">
                            Lokasi / Gudang
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('admin.stock.index')">
                            Stock
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                <x-nav-link :href="route('admin.recipes.index')" :active="request()->routeIs('admin.recipes.*')">
                    Manajemen Resep
                </x-nav-link>

                <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    Pengguna Sistem
                </x-nav-link>
            </nav>
        </div>

        {{-- Right Section --}}
        <div class="flex items-center">
            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition"
                onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                Logout
            </button>
        </div>
    </div>
</div>

<form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>