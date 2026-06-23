@extends('layouts.app')

    @section('header')
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900">
                {{ __('Kelola Kamera / Produk') }}
            </h2>
            <a 
                href="{{ route('menu.products.create') }}" 
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-slate-800 hover:bg-slate-700 focus:outline-none transition duration-150 font-sans"
            >
                Tambah Produk
            </a>
        </div>
    @endsection

@section('content')

    <div class="py-2">
        <div class="max-w-7xl mx-auto space-y-6">

            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-sm font-bold text-gray-900">Katalog Produk</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Kelola data kamera sewaan, stok barang, dan atur harga sewa harian.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100 font-sans">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-center w-16">No</th>
                                <th scope="col" class="px-6 py-4">Nama Produk</th>
                                <th scope="col" class="px-6 py-4">Kategori</th>
                                <th scope="col" class="px-6 py-4">Harga Sewa / Hari</th>
                                <th scope="col" class="px-6 py-4 text-center">Stok</th>
                                <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($products as $index => $product)
                                <tr class="hover:bg-gray-50/50 transition duration-150">
                                    <td class="px-6 py-4 text-center font-medium text-gray-450">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-800">
                                        {{ $product->produk_name }}
                                    </td>
                                    <td class="px-6 py-4 font-sans">
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600 border border-gray-150">
                                            {{ $product->category->kategori_name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-mono font-semibold text-slate-800">
                                        Rp {{ number_format($product->prices['6'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center font-sans">
                                        <span class="px-2 py-0.5 rounded text-xs font-bold {{ $product->unit > 0 ? 'bg-slate-50 text-slate-700 border border-slate-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                            {{ $product->unit }} Unit
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-sans">
                                        <div class="flex items-center justify-center space-x-2.5">

                                            <a 
                                                href="{{ route('menu.products.edit', $product->id_produk) }}" 
                                                class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-slate-50 hover:text-slate-850 text-gray-600 text-xs font-semibold rounded-lg transition duration-150 border border-transparent hover:border-slate-200"
                                            >
                                                Edit
                                            </a>
                                            <form action="{{ route('menu.products.destroy', $product->id_produk) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-semibold rounded-lg transition duration-150 border border-transparent">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 font-sans">
                                        Belum ada data produk kamera. Silakan tambahkan kamera baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
