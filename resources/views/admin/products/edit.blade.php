@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900">
            {{ __('Edit Produk / Kamera') }}
        </h2>
        <a href="{{ route('menu.products.index') }}"
            class="inline-flex items-center px-4 py-2 border border-gray-200 rounded-lg shadow-sm text-xs font-semibold text-gray-600 bg-white hover:bg-gray-50 focus:outline-none transition duration-150 font-sans">
            Kembali
        </a>
    </div>
@endsection

@section('content')

    <div class="py-2">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 md:p-8 font-sans">
                <form action="{{ route('menu.products.update', $product->id_produk) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Produk -->
                        <div class="md:col-span-2">
                            <label for="produk_name" class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama
                                Produk / Kamera</label>
                            <input type="text" name="produk_name" id="produk_name"
                                value="{{ old('produk_name', $product->produk_name) }}" required
                                class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="category_id"
                                class="block text-xs font-semibold text-gray-500 uppercase mb-2">Kategori</label>
                            <select name="category_id" id="category_id" required
                                class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id_kategori }}" {{ old('category_id', $product->category_id) == $category->id_kategori ? 'selected' : '' }}>
                                        {{ $category->kategori_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Stok (unit) -->
                        <div>
                            <label for="unit" class="block text-xs font-semibold text-gray-500 uppercase mb-2">Stok Unit
                                Kamera</label>
                            <input type="number" name="unit" id="unit" value="{{ old('unit', $product->unit) }}" min="0"
                                required
                                class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">
                        </div>

                        <!-- Harga Sewa Paket -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Harga Sewa Paket (IDR)</label>
                            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                                <!-- 5 Menit (Test) -->
                                <div>
                                    <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Paket 5 Menit</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 font-semibold text-sm">Rp</div>
                                        <input type="number" name="prices[0]" value="{{ old('prices.0', $product->prices['0'] ?? 10000) }}" placeholder="Contoh: 10000" class="w-full bg-white border border-gray-200 rounded-lg py-2 pl-10 pr-3 text-sm text-gray-800 placeholder-gray-405 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">
                                    </div>
                                    @error('prices.0')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <!-- 6 Jam -->
                                <div>
                                    <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Paket 6 Jam</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 font-semibold text-sm">Rp</div>
                                        <input type="number" name="prices[6]" value="{{ old('prices.6', $product->prices['6'] ?? '') }}" required placeholder="Contoh: 55000" class="w-full bg-white border border-gray-200 rounded-lg py-2 pl-10 pr-3 text-sm text-gray-800 placeholder-gray-405 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">
                                    </div>
                                    @error('prices.6')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <!-- 12 Jam -->
                                <div>
                                    <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Paket 12 Jam</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 font-semibold text-sm">Rp</div>
                                        <input type="number" name="prices[12]" value="{{ old('prices.12', $product->prices['12'] ?? '') }}" required placeholder="Contoh: 80000" class="w-full bg-white border border-gray-200 rounded-lg py-2 pl-10 pr-3 text-sm text-gray-800 placeholder-gray-405 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">
                                    </div>
                                    @error('prices.12')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <!-- 24 Jam -->
                                <div>
                                    <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Paket 24 Jam</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 font-semibold text-sm">Rp</div>
                                        <input type="number" name="prices[24]" value="{{ old('prices.24', $product->prices['24'] ?? '') }}" required placeholder="Contoh: 120000" class="w-full bg-white border border-gray-200 rounded-lg py-2 pl-10 pr-3 text-sm text-gray-800 placeholder-gray-405 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">
                                    </div>
                                    @error('prices.24')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="md:col-span-2">
                            <label for="description"
                                class="block text-xs font-semibold text-gray-500 uppercase mb-2">Deskripsi Produk</label>
                            <textarea name="description" id="description" rows="5"
                                class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <!-- Upload Foto Tambahan -->
                        <div>
                            <label for="photos" class="block text-xs font-semibold text-gray-500 uppercase mb-2">Upload
                                Tambahan Foto (Bisa lebih dari 1)</label>
                            <input type="file" name="photos[]" id="photos" multiple accept="image/*"
                                class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100">
                            <p class="text-xs text-gray-400 mt-2">Pilih file baru jika ingin menambahkan foto ke galeri ini.
                            </p>
                            @error('photos.*')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload Hasil Jepretan -->
                        <div>
                            <label for="results" class="block text-xs font-semibold text-gray-500 uppercase mb-2">Upload Hasil Jepretan</label>
                            <input type="file" name="results[]" id="results" multiple accept="image/*"
                                class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100">
                            <p class="text-xs text-gray-400 mt-2">Pilih file baru jika ingin menambahkan foto hasil jepretan.</p>
                            @error('results.*')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit"
                            class="inline-flex justify-center py-2.5 px-6 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-slate-800 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition duration-150">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Galeri Foto Saat Ini -->
            <div class="mt-8 bg-white border border-gray-100 shadow-sm rounded-2xl p-6 md:p-8 font-sans">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Galeri Foto Tersimpan</h3>

                @if($product->galleries && $product->galleries->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($product->galleries as $gallery)
                            <div class="relative group rounded-xl overflow-hidden border border-gray-200 aspect-square bg-gray-50">
                                <img src="{{ Storage::url($gallery->foto) }}" alt="Foto Produk" class="w-full h-full object-cover">

                                <div
                                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <form action="{{ route('menu.products.gallery.destroy', $gallery->id_gallery) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors shadow-sm"
                                            title="Hapus Foto">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-3 text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-gray-500 text-sm font-medium">Belum ada foto yang di-upload.</p>
                        <p class="text-gray-400 text-xs mt-1">Upload foto melalui form di atas.</p>
                    </div>
                @endif
            </div>

            <!-- Galeri Hasil Jepretan -->
            <div class="mt-8 bg-white border border-gray-100 shadow-sm rounded-2xl p-6 md:p-8 font-sans">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Galeri Hasil Jepretan</h3>

                @if($product->results && $product->results->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($product->results as $result)
                            <div class="relative group aspect-square rounded-xl overflow-hidden border border-gray-100 shadow-sm">
                                <img src="{{ Storage::url($result->foto) }}" alt="Hasil Jepretan" class="w-full h-full object-cover">

                                <div
                                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <form action="{{ route('menu.products.result.destroy', $result->id_result) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors shadow-sm"
                                            title="Hapus Foto">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-3 text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-gray-500 text-sm font-medium">Belum ada foto hasil jepretan yang di-upload.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
