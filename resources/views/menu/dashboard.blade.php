@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-[13px] text-gray-500 mt-0.5 font-sans">
                {{ now()->isoFormat('dddd, D MMMM YYYY') }}
            </p>
        </div>
        <div
            class="hidden sm:flex items-center gap-2 bg-white border border-gray-200 rounded-xl px-3.5 py-2 text-[13px] text-gray-600 shadow-sm font-sans">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Hari ini, {{ now()->format('d M Y') }}
        </div>
    </div>
@endsection

@section('content')

    <div class="py-2">
        <!-- Welcome Card -->
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 relative overflow-hidden mb-6">
            <!-- Decorative radial gradient -->
            <div class="absolute right-0 top-0 w-96 h-96 bg-slate-500/5 rounded-full filter blur-3xl pointer-events-none">
            </div>

            <h1 class="text-2xl font-bold text-gray-900">Selamat datang kembali, {{ Auth::user()->name }}!</h1>
            <p class="text-xs text-gray-500 mt-1 max-w-2xl leading-relaxed font-sans">
                Berikut adalah ringkasan performa operasional sistem persewaan kamera Anda hari ini. Anda dapat mengelola
                katalog produk, melacak status booking sewa, memverifikasi KTP, dan memantau keuangan toko dengan mudah.
            </p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

            <!-- Earnings Card -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-100">
                        <svg class="w-5 h-5 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-[11px] font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full font-sans">
                        Kas Masuk
                    </span>
                </div>
                <p class="text-2xl font-bold text-gray-900 leading-none">
                    Rp {{ number_format($totalEarnings, 0, ',', '.') }}
                </p>
                <p class="text-[13px] text-gray-500 mt-1 font-sans">Total Pendapatan Riil</p>
            </div>

            <!-- Active Rentals Card -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-[11px] font-semibold text-sky-600 bg-sky-50 px-2 py-0.5 rounded-full font-sans">
                        Aktif Sewa
                    </span>
                </div>
                <p class="text-2xl font-bold text-gray-900 leading-none">
                    {{ $activeRentals }} <span class="text-xs font-normal text-gray-400 font-sans">Unit</span>
                </p>
                <p class="text-[13px] text-gray-500 mt-1 font-sans">Sewaan Sedang Berjalan</p>
            </div>

            <!-- Pending Bookings Card -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    @if($pendingTransactions > 0)
                        <span
                            class="text-[11px] font-semibold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full font-sans animate-pulse">
                            Butuh Aksi
                        </span>
                    @else
                        <span class="text-[11px] font-semibold text-gray-400 bg-gray-50 px-2 py-0.5 rounded-full font-sans">
                            Aman
                        </span>
                    @endif
                </div>
                <p
                    class="text-2xl font-bold {{ $pendingTransactions > 0 ? 'text-rose-600' : 'text-gray-900' }} leading-none">
                    {{ $pendingTransactions }} <span class="text-xs font-normal text-gray-400 font-sans">Booking</span>
                </p>
                <p class="text-[13px] text-gray-500 mt-1 font-sans">Menunggu Konfirmasi</p>
            </div>

            <!-- Total Users Card -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="text-[11px] font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full font-sans">
                        Member
                    </span>
                </div>
                <p class="text-2xl font-bold text-gray-900 leading-none">
                    {{ $totalUsers }} <span class="text-xs font-normal text-gray-400 font-sans">User</span>
                </p>
                <p class="text-[13px] text-gray-500 mt-1 font-sans">Total Member Terdaftar</p>
            </div>

        </div>

        <!-- Details and Quick Links -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

            <!-- Quick Links -->
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5">
                <h3 class="text-[15px] font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">Akses Navigasi Cepat</h3>

                <div class="space-y-2.5 font-sans">
                    <a href="{{ route('menu.products.index') }}"
                        class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-slate-50 hover:text-slate-800 transition duration-150 group border border-transparent hover:border-slate-100">
                        <span class="text-[13px] text-gray-600 group-hover:text-slate-800 font-medium">Kelola Katalog
                            Kamera</span>
                        <span
                            class="text-xs text-gray-400 bg-white px-2 py-0.5 rounded-md border border-gray-100 group-hover:border-slate-100">{{ $totalProducts }}</span>
                    </a>

                    <a href="{{ route('menu.categories.index') }}"
                        class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-slate-50 hover:text-slate-800 transition duration-150 group border border-transparent hover:border-slate-100">
                        <span class="text-[13px] text-gray-600 group-hover:text-slate-800 font-medium">Atur Kategori
                            Kamera</span>
                        <span
                            class="text-xs text-gray-400 bg-white px-2 py-0.5 rounded-md border border-gray-100 group-hover:border-slate-100">{{ $totalCategories }}</span>
                    </a>

                    <a href="{{ route('menu.users.index') }}"
                        class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-slate-50 hover:text-slate-800 transition duration-150 group border border-transparent hover:border-slate-100">
                        <span class="text-[13px] text-gray-600 group-hover:text-slate-800 font-medium">Kelola Akun
                            Pelanggan</span>
                        <span
                            class="text-xs text-gray-400 bg-white px-2 py-0.5 rounded-md border border-gray-100 group-hover:border-slate-100">{{ $totalUsers }}</span>
                    </a>

                    <a href="{{ route('menu.reports.index') }}"
                        class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-slate-50 hover:text-slate-800 transition duration-150 group border border-transparent hover:border-slate-100">
                        <span class="text-[13px] text-gray-600 group-hover:text-slate-800 font-medium">Download Laporan
                            Laba</span>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-slate-700" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 2v-6m-9 9h11a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Operations Instruction -->
            <div class="lg:col-span-2 bg-white border border-gray-100 shadow-sm rounded-2xl p-5">
                <h3 class="text-[15px] font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">Informasi Operasional
                    Penyewaan</h3>

                <div class="space-y-4 font-sans text-sm text-gray-600 leading-relaxed">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <h4 class="font-semibold text-gray-800 text-xs uppercase tracking-wider mb-2">Panduan Validasi
                            Booking & Verifikasi:</h4>
                        <ol class="list-decimal list-inside text-xs text-gray-500 space-y-2">
                            <li>Periksa daftar booking baru masuk pada tab <strong>Booking Masuk</strong> (status awal
                                adalah <code>pending</code>).</li>
                            <li>Buka detail transaksi untuk memverifikasi file identitas kartu KTP pelanggan.</li>
                            <li>Berikan persetujuan status KTP agar pelanggan diizinkan mengambil unit kamera di toko fisik.
                            </li>
                            <li>Saat pelanggan mengembalikan unit kamera dan melunasi pembayaran, verifikasi bukti transfer
                                pelunasan, lalu ubah status transaksi menjadi <code>completed</code>.</li>
                        </ol>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection