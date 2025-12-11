<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventara F&B Core - PoS Restoran Modern & Terintegrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
    </style>
</head>

<body class="bg-white text-gray-900 antialiased">

    <!-- Navigation -->
    <nav class="fixed w-full bg-white/80 backdrop-blur-md z-50 border-b border-gray-100">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-2xl font-bold text-gray-900">Inventara</div>
                <div class="hidden md:flex items-center gap-8">
                    <a href="#fitur" class="text-gray-600 hover:text-gray-900 transition">Fitur</a>
                    <a href="{{ route('login') }}"
                        class="px-5 py-2.5 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition text-sm font-medium">Masuk</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 px-6">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center fade-in-up">
                <div class="inline-block mb-4 px-4 py-1.5 bg-gray-100 rounded-full text-sm font-medium text-gray-700">
                    PoS & Inventory Management
                </div>
                <h1 class="text-5xl md:text-7xl font-bold mb-6 tracking-tight">
                    Kelola restoran<br />dengan <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">lebih
                        efisien</span>
                </h1>
                <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Sistem PoS dan inventaris berbasis resep untuk restoran, kafe, dan cloud kitchen modern
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">

                    <a href="{{ route('login') }}"
                        class="px-8 py-4 bg-gray-900 text-white rounded-xl hover:bg-gray-800 transition font-medium text-base">
                        Masuk ke Sistem Admin
                    </a>

                    <a href="#fitur"
                        class="px-8 py-4 text-gray-700 hover:text-gray-900 transition font-medium text-base flex items-center gap-2">
                        Lihat Fitur Lengkap
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="mt-20 relative" x-data="{ active: 0 }"
                x-init="setInterval(() => { active = (active + 1) % 3 }, 3000)">
                <div class="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-8 rounded-2xl border border-indigo-100 transform transition-all duration-500"
                        :class="active === 0 ? 'scale-105 shadow-xl' : 'scale-100 opacity-75'">
                        <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">3.2k</div>
                        <div class="text-sm text-gray-600">Transaksi Hari Ini</div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-8 rounded-2xl border border-purple-100 transform transition-all duration-500"
                        :class="active === 1 ? 'scale-105 shadow-xl' : 'scale-100 opacity-75'">
                        <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">94%</div>
                        <div class="text-sm text-gray-600">Stok Tersedia</div>
                    </div>

                    <div class="bg-gradient-to-br from-pink-50 to-orange-50 p-8 rounded-2xl border border-pink-100 transform transition-all duration-500"
                        :class="active === 2 ? 'scale-105 shadow-xl' : 'scale-100 opacity-75'">
                        <div class="w-12 h-12 bg-pink-600 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">+28%</div>
                        <div class="text-sm text-gray-600">Growth Bulan Ini</div>
                    </div>
                </div>

                <div
                    class="absolute -top-10 -left-10 w-32 h-32 bg-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse">
                </div>
                <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"
                    style="animation-delay: 1s;"></div>
            </div>
        </div>
    </section>
    <!-- Stats Section -->
    <section class="py-16 px-6 bg-gray-50">
        <div class="container mx-auto max-w-6xl">
            <div class="grid md:grid-cols-3 gap-12 text-center">
                <div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">100+</div>
                    <div class="text-gray-600">Restoran Aktif</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">50K+</div>
                    <div class="text-gray-600">Transaksi/Bulan</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">99.9%</div>
                    <div class="text-gray-600">Uptime</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-24 px-6">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight">
                    Semua yang Anda butuhkan
                </h2>
                <p class="text-xl text-gray-600">Fitur lengkap untuk operasional restoran modern</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature Card 1 -->
                <div class="p-8 rounded-2xl bg-white border border-gray-200 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Transaksi Cepat</h3>
                    <p class="text-gray-600 leading-relaxed">Proses pesanan dalam hitungan detik dengan antarmuka yang
                        intuitif</p>
                </div>

                <!-- Feature Card 2 -->
                <div class="p-8 rounded-2xl bg-white border border-gray-200 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.6" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Inventaris Otomatis</h3>
                    <p class="text-gray-600 leading-relaxed">Stok bahan baku terpotong otomatis sesuai resep setiap
                        pesanan</p>
                </div>

                <!-- Feature Card 3 -->
                <div class="p-8 rounded-2xl bg-white border border-gray-200 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Laporan Real-time</h3>
                    <p class="text-gray-600 leading-relaxed">Monitor penjualan, profit, dan stok kapan saja dari mana
                        saja</p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-24 px-6 bg-gray-50">
        <div class="container mx-auto max-w-4xl">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">Fitur Utama Inventara F&B Core</h2>
                <p class="text-xl text-gray-600">Fokus pada akurasi stok bahan baku & manajemen transaksi</p>
            </div>

            <div class="grid md:grid-cols-2 gap-x-12 gap-y-6 max-w-3xl mx-auto">

                {{-- 1. PoS Mobile Interface (Frontend Kritis) --}}
                <div class="flex items-start gap-4">
                    <div
                        class="w-5 h-5 rounded-full bg-indigo-600 flex-shrink-0 mt-0.5 flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">PoS Mobile App (Flutter)</div>
                        <div class="text-sm text-gray-600 mt-0.5">Antarmuka cepat dan *stateless* untuk kasir.</div>
                    </div>
                </div>

                {{-- 2. Resep & BOM (Core Logic F&B) --}}
                <div class="flex items-start gap-4">
                    <div
                        class="w-5 h-5 rounded-full bg-indigo-600 flex-shrink-0 mt-0.5 flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">Manajemen Resep & BOM</div>
                        <div class="text-sm text-gray-600 mt-0.5">Definisi kebutuhan bahan baku (Bill of Materials) per
                            Menu.</div>
                    </div>
                </div>

                {{-- 3. Otomatis Potong Stok Bahan (Atomic Transaction) --}}
                <div class="flex items-start gap-4">
                    <div
                        class="w-5 h-5 rounded-full bg-indigo-600 flex-shrink-0 mt-0.5 flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">Atomic Stock Deduction</div>
                        <div class="text-sm text-gray-600 mt-0.5">Otomatis memotong stok bahan baku berdasarkan resep
                            saat penjualan (dijamin aman via DB Transaction).</div>
                    </div>
                </div>

                {{-- 4. Multi Lokasi & Gudang --}}
                <div class="flex items-start gap-4">
                    <div
                        class="w-5 h-5 rounded-full bg-indigo-600 flex-shrink-0 mt-0.5 flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">Kontrol Stok Multi Lokasi</div>
                        <div class="text-sm text-gray-600 mt-0.5">Pelacakan stok bahan baku per gudang/outlet.</div>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div
                        class="w-5 h-5 rounded-full bg-indigo-600 flex-shrink-0 mt-0.5 flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">User Role & Hak Akses (Admin/Staff)</div>
                        <div class="text-sm text-gray-600 mt-0.5">Kontrol akses multi-level via IsAdmin Middleware.
                        </div>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div
                        class="w-5 h-5 rounded-full bg-indigo-600 flex-shrink-0 mt-0.5 flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">Audit Trail Stok & Penjualan</div>
                        <div class="text-sm text-gray-600 mt-0.5">Laporan pergerakan stok (ledger) dan riwayat penjualan
                            (`ReportController`).</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 px-6">
        <div class="container mx-auto max-w-4xl">
            <div
                class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-3xl p-12 md:p-16 text-center text-white">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Siap untuk memulai?
                </h2>
                <p class="text-xl mb-10 opacity-90">
                    Coba gratis tanpa basa basi.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#"
                        class="px-8 py-4 bg-white text-indigo-600 rounded-xl hover:bg-gray-100 transition font-semibold text-base">
                        Mulai Uji Coba
                    </a>
                    <a href="#"
                        class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-xl hover:bg-white/10 transition font-semibold text-base">
                        Hubungi Sales
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 px-6 border-t border-gray-200">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900 mb-4">Inventara</div>
                <p class="text-gray-600 mb-6">PoS & Inventory Management untuk Restoran Modern</p>
                <p class="text-sm text-gray-500">© 2025 Inventara. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>