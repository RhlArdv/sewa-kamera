@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Back Link -->
        <div>
            <a href="{{ route('cart.index') }}"
                class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-gray-900 transition duration-200 focus-visible:ring-2 focus-visible:ring-slate-500 rounded-md outline-none">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Keranjang
            </a>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Checkout & Pembayaran DP</h1>

        <!-- Errors Alert -->
        @if($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-100 text-rose-800 rounded-xl text-xs font-semibold" role="alert"
                aria-live="polite">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data"
            class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            @csrf

            <!-- Left: Form Fields (Span 2) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-gray-100 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
                    <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-4">Data Verifikasi &
                        Pengambilan</h3>

                    <!-- Grid Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Receiver -->
                        <div>
                            <label for="receiver"
                                class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2">Nama
                                Penerima (Sesuai KTP)</label>
                            <input type="text" name="receiver" id="receiver"
                                value="{{ old('receiver', Auth::user()->name) }}" required
                                class="block w-full px-3.5 py-2 border border-gray-200 rounded-xl bg-gray-50 text-gray-805 focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 transition duration-200 text-xs font-semibold">
                        </div>

                        <!-- Location Box -->
                        <div class="sm:col-span-2">
                            <label
                                class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2">Lokasi
                                Pengambilan & Pengembalian Kamera</label>
                            <a href="https://maps.app.goo.gl/LvM6rKGJV7pLsL1CA" target="_blank"
                                class="block p-4 border border-blue-100 bg-blue-50/50 hover:bg-blue-100/50 transition rounded-xl flex items-start gap-3">
                                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg shrink-0 mt-0.5">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-900 leading-none">Sewa Kamera Padang</h4>
                                    <p class="text-[11px] text-gray-600 mt-1.5 leading-relaxed font-sans">
                                        Jl. Gajah No.VII, Air Tawar Bar., Kec. Padang Utara, Kota Padang, Sumatera Barat
                                        25132
                                    </p>
                                    <p
                                        class="text-[10px] text-blue-600 font-semibold mt-1 font-sans flex items-center gap-1">
                                        <span>Buka di Google Maps</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                            </path>
                                        </svg>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>


                    <!-- Description/Notes -->
                    <div>
                        <label for="keterangan"
                            class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2">Catatan
                            Tambahan (Opsional)</label>
                        <textarea name="keterangan" id="keterangan" rows="3"
                            placeholder="Contoh: Membawa perlengkapan ekstra sendiri…"
                            class="block w-full px-3.5 py-2 border border-gray-200 rounded-xl bg-gray-50 text-gray-805 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 transition duration-200 text-xs font-semibold">{{ old('keterangan') }}</textarea>
                    </div>

                    <!-- KTP Upload -->
                    <div x-data="{ 
                                    fileName: '', 
                                    filePreview: null,
                                    handleFile(e) {
                                        const file = e.target.files[0];
                                        if (!file) return;
                                        this.fileName = file.name;
                                        const reader = new FileReader();
                                        reader.onload = (event) => {
                                            this.filePreview = event.target.result;
                                        };
                                        reader.readAsDataURL(file);
                                    }
                                }">
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2">Unggah
                            Foto KTP (Sebagai Jaminan & Verifikasi)</label>

                        <div
                            class="relative border-2 border-dashed border-gray-200 hover:border-gray-300 rounded-2xl p-8 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100/50 transition duration-200 cursor-pointer">
                            <input type="file" name="ktp" id="ktp" required accept="image/*" @change="handleFile"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10 focus-visible:ring-2 focus-visible:ring-slate-500 outline-none">

                            <div class="text-center space-y-3" x-show="!filePreview">
                                <div
                                    class="p-3.5 bg-white border border-gray-100 rounded-full text-gray-400 inline-block shadow-sm">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold text-gray-700">Klik atau seret foto KTP ke sini</p>
                                <p class="text-[10px] text-gray-400">Mendukung berkas JPG, JPEG, PNG (Maksimal 2MB)</p>
                            </div>

                            <!-- Preview Container -->
                            <div class="w-full text-center space-y-3" x-show="filePreview" x-cloak>
                                <img :src="filePreview"
                                    class="mx-auto max-h-40 rounded-xl object-contain border border-gray-200 shadow-md">
                                <p class="text-[11px] font-bold text-gray-700" x-text="fileName"></p>
                                <p class="text-[10px] text-gray-400">Klik kembali untuk mengganti foto KTP</p>
                            </div>
                        </div>

                        <!-- Embedded Map Section -->
                        <div class="mt-8">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-900 tracking-tight">Peta Lokasi Pengambilan</h3>
                            </div>
                            <div class="w-full h-64 rounded-xl overflow-hidden border border-gray-200 shadow-sm relative">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2779.2941590993923!2d100.34623704572206!3d-0.8974988839886484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4bfe6ddf93cc9%3A0xd8ed7331479acdd7!2sLaptopCare%20Padang%20(Jasa%20Service%20Laptop%2C%20Jual%20Beli%20Laptop%2C%20Gratis%20Antar%20Jemput)!5e0!3m2!1sid!2sid!4v1782118108555!5m2!1sid!2sid"
                                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                                <!-- Clickable Overlay for Mobile -->
                                <a href="https://maps.app.goo.gl/LvM6rKGJV7pLsL1CA" target="_blank"
                                    class="absolute inset-0 z-10 md:hidden" aria-label="Buka di Google Maps"></a>
                            </div>
                            <p class="text-[11px] text-gray-500 mt-2 font-sans">* Anda dapat mengikuti panduan rute dari
                                Google Maps ini saat hari pengambilan.</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right: Summary Sidebar (Span 1) -->
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm space-y-6">
                <h3 class="text-base font-bold text-gray-900">Detail Pembayaran</h3>

                <div class="space-y-4 text-xs text-gray-500 border-b border-gray-100 pb-5">
                    <!-- Items Loop -->
                    @foreach($cartItems as $item)
                        <div
                            class="flex justify-between items-start text-xs border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                            <div class="space-y-1.5 w-full pr-4">
                                <p class="font-bold text-gray-800">{{ $item->product->produk_name }}</p>
                                <p class="text-[10px] text-gray-400 font-mono">{{ $item->banyak }} Unit x
                                    {{ $item->duration_hours }} Jam
                                </p>
                                <div class="bg-gray-50 rounded-lg p-2 mt-1.5 border border-gray-100">
                                    <p class="text-[9px] font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Jadwal
                                        Sewa:</p>
                                    <p class="text-[10px] text-gray-700 font-mono">Mulai:
                                        {{ $item->start_time->format('d M Y H:i') }}
                                    </p>
                                    <p class="text-[10px] text-gray-700 font-mono">Selesai:
                                        {{ $item->end_time->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                            <span
                                class="font-bold text-gray-700 font-mono">Rp&nbsp;{{ number_format($item->total, 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    <div class="flex justify-between pt-3 border-t border-gray-100">
                        <span>Subtotal Sewa:</span>
                        <span
                            class="font-bold text-gray-800 font-mono">Rp&nbsp;{{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-100 pt-4 font-bold text-gray-800">
                        <span>Uang Panjar (DP 30%):</span>
                        <span class="text-slate-800 font-mono">Rp&nbsp;{{ number_format($dpAmount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-[11px] text-gray-400">
                        <span>Sisa Pelunasan (Saat Ambil):</span>
                        <span class="font-mono">Rp&nbsp;{{ number_format($totalPrice - $dpAmount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-baseline mb-6">
                        <div>
                            <span class="text-[10px] font-bold text-gray-450 uppercase block tracking-wider">Bayar DP
                                Sekarang</span>
                            <span class="text-[9px] text-gray-400 font-semibold">(Via Midtrans)</span>
                        </div>
                        <span
                            class="text-2xl font-bold text-gray-900 font-mono">Rp&nbsp;{{ number_format($dpAmount, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit"
                        class="w-full flex items-center justify-center px-4 py-2.5 bg-[#9E1B22] hover:bg-[#7A151B] text-white font-bold text-sm rounded-lg shadow transition duration-200 focus-visible:ring-2 focus-visible:ring-red-500 outline-none">
                        Buat Pesanan
                        <svg class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <p class="mt-4 text-[9px] text-gray-400 text-center leading-relaxed font-sans">
                        Dengan memproses pembayaran, Anda menyetujui syarat sewa serta bertanggung jawab penuh atas
                        penggunaan unit kamera yang dipesan.
                    </p>

                    <!-- Late Return Warning -->
                    <div class="mt-4 p-3 bg-red-50 border border-red-100 rounded-xl">
                        <div class="flex items-start">
                            <svg class="h-4 w-4 text-red-500 mt-0.5 mr-2 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <h4 class="text-[10px] font-bold text-red-800 uppercase tracking-wider">Perhatian:
                                    Keterlambatan Pengembalian</h4>
                                <p class="text-[9px] text-red-600 mt-1 leading-relaxed font-sans">
                                    Mohon kembalikan perangkat tepat waktu sesuai jadwal selesai sewa. Keterlambatan akan
                                    dikenakan denda proporsional sesuai tarif sewa dan kebijakan toko.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection