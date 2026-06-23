@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900">
            {{ __('Tambah Produk Baru') }}
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
                <form action="{{ route('menu.products.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Produk -->
                        <div class="md:col-span-2">
                            <label for="produk_name" class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama
                                Produk / Kamera</label>
                            <input type="text" name="produk_name" id="produk_name" value="{{ old('produk_name') }}" required
                                placeholder="Contoh: Sony Alpha A6400 Kit 16-50mm"
                                class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 placeholder-gray-405 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="category_id"
                                class="block text-xs font-semibold text-gray-500 uppercase mb-2">Kategori</label>
                            <select name="category_id" id="category_id" required
                                class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id_kategori }}" {{ old('category_id') == $category->id_kategori ? 'selected' : '' }}>
                                        {{ $category->kategori_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Stok (unit) -->
                        <div>
                            <label for="unit" class="block text-xs font-semibold text-gray-500 uppercase mb-2">Stok Unit
                                Kamera</label>
                            <input type="number" name="unit" id="unit" value="{{ old('unit', 0) }}" min="0" required
                                class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">
                        </div>

                        <!-- Harga Sewa Paket -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Harga Sewa Paket (IDR)</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <!-- 6 Jam -->
                                <div>
                                    <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Paket 6 Jam</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 font-semibold text-sm">Rp</div>
                                        <input type="number" name="prices[6]" value="{{ old('prices.6') }}" required placeholder="Contoh: 55000" class="w-full bg-white border border-gray-200 rounded-lg py-2 pl-10 pr-3 text-sm text-gray-800 placeholder-gray-405 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">
                                    </div>
                                    @error('prices.6')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <!-- 12 Jam -->
                                <div>
                                    <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Paket 12 Jam</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 font-semibold text-sm">Rp</div>
                                        <input type="number" name="prices[12]" value="{{ old('prices.12') }}" required placeholder="Contoh: 80000" class="w-full bg-white border border-gray-200 rounded-lg py-2 pl-10 pr-3 text-sm text-gray-800 placeholder-gray-405 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">
                                    </div>
                                    @error('prices.12')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <!-- 24 Jam -->
                                <div>
                                    <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Paket 24 Jam</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 font-semibold text-sm">Rp</div>
                                        <input type="number" name="prices[24]" value="{{ old('prices.24') }}" required placeholder="Contoh: 120000" class="w-full bg-white border border-gray-200 rounded-lg py-2 pl-10 pr-3 text-sm text-gray-800 placeholder-gray-405 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">
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
                                placeholder="Masukkan spesifikasi produk, kelengkapan aksesoris, dan kondisi barang..."
                                class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 placeholder-gray-405 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150">{{ old('description') }}</textarea>
                        </div>

                        <!-- Upload Foto Multiple -->
                        <div>
                            <label for="photos" class="block text-xs font-semibold text-gray-500 uppercase mb-2">Upload Foto
                                Kamera (Bisa lebih dari 1)</label>
                            <input type="file" name="photos[]" id="photos" multiple accept="image/*"
                                class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100">
                            <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG, WEBP. Maks 2MB per file. Anda dapat
                                memilih beberapa file sekaligus.</p>
                            @error('photos.*')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload Hasil Jepretan -->
                        <div>
                            <label for="results" class="block text-xs font-semibold text-gray-500 uppercase mb-2">Upload Hasil Jepretan</label>
                            <input type="file" name="results[]" id="results" multiple accept="image/*"
                                class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100">
                            <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG, WEBP. Maks 2MB per file. Opsional.</p>
                            @error('results.*')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit"
                            class="inline-flex justify-center py-2.5 px-6 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-slate-800 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition duration-150">
                            Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
