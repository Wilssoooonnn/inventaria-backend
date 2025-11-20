<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
        <div class="flex">
            <div class="shrink-0 flex items-center">
                <a href="{{ route('admin.dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
            </div>

            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                    {{ __('Produk & Menu') }}
                </x-nav-link>
                <x-nav-link :href="route('admin.units.index')" :active="request()->routeIs('admin.units.*')">
                    {{ __('Satuan Unit') }}
                </x-nav-link>
                <x-nav-link :href="route('admin.recipes.index')" :active="request()->routeIs('admin.recipes.*')">
                    {{ __('Manajemen Resep') }}
                </x-nav-link>
            </div>
        </div>
    </div>
</div>