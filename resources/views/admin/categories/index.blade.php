@extends('layouts.app')

    @section('header')
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900">
                {{ __('Kategori Kamera') }}
            </h2>
        </div>
    @endsection

@section('content')

    <div class="py-2" x-data="{ openEditModal: false, editId: null, editName: '' }">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Tabel Kategori (2/3 Width) -->
                <div class="lg:col-span-2 bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-sm font-bold text-gray-900">Daftar Kategori</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Daftar kategori kamera yang aktif pada katalog persewaan.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-450 uppercase bg-gray-50 border-b border-gray-100 font-sans">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5 w-16 text-center">ID</th>
                                    <th scope="col" class="px-6 py-3.5">Nama Kategori</th>
                                    <th scope="col" class="px-6 py-3.5">Slug</th>
                                    <th scope="col" class="px-6 py-3.5 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($categories as $category)
                                    <tr class="hover:bg-gray-50/50 transition duration-150">
                                        <td class="px-6 py-4 text-center font-medium text-gray-400">{{ $category->id_kategori }}</td>
                                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $category->kategori_name }}</td>
                                        <td class="px-6 py-4 font-mono text-xs text-gray-400">{{ $category->slug }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center space-x-2.5">
                                                <button 
                                                    @click="openEditModal = true; editId = {{ $category->id_kategori }}; editName = '{{ addslashes($category->kategori_name) }}'" 
                                                    class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-slate-50 hover:text-slate-850 text-gray-600 text-xs font-semibold rounded-lg transition duration-150 border border-transparent hover:border-slate-200"
                                                >
                                                    Edit
                                                </button>
                                                
                                                <form action="{{ route('menu.categories.destroy', $category->id_kategori) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua produk di kategori ini juga akan terpengaruh.')">
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
                                        <td colspan="4" class="px-6 py-10 text-center text-gray-400 font-sans">
                                            Belum ada data kategori.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Form Tambah Kategori (1/3 Width) -->
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 h-fit">
                    <h3 class="text-sm font-bold text-gray-900 mb-1">Tambah Kategori Baru</h3>
                    <p class="text-xs text-gray-400 mb-5 font-sans">Buat kategori baru untuk mengelompokkan kamera sewaan Anda.</p>

                    <form action="{{ route('menu.categories.store') }}" method="POST" class="space-y-4 font-sans">
                        @csrf
                        <div>
                            <label for="kategori_name" class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama Kategori</label>
                            <input 
                                type="text" 
                                name="kategori_name" 
                                id="kategori_name" 
                                required
                                placeholder="Contoh: DSLR, Mirrorless, Lensa"
                                class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150"
                            >
                        </div>
                        <button type="submit" class="w-full inline-flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-slate-800 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition duration-150">
                            Simpan Kategori
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit Kategori -->
        <div 
            x-show="openEditModal" 
            class="fixed inset-0 z-50 overflow-y-auto" 
            style="display: none;"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Overlay -->
                <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" @click="openEditModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Content -->
                <div 
                    x-show="openEditModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full font-sans border border-gray-100"
                >
                    <div class="p-6">
                        <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-5">
                            <h3 class="text-base font-bold text-gray-900">Edit Kategori</h3>
                            <button @click="openEditModal = false" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form :action="'{{ route('menu.categories.index') }}/' + editId" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="edit_kategori_name" class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama Kategori</label>
                                <input 
                                    type="text" 
                                    name="kategori_name" 
                                    id="edit_kategori_name" 
                                    x-model="editName"
                                    required
                                    class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150"
                                    style="box-sizing: border-box;"
                                >
                            </div>
                            
                            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100 mt-6">
                                <button type="button" @click="openEditModal = false" class="inline-flex justify-center py-2 px-4 border border-gray-200 rounded-lg shadow-sm text-xs font-semibold text-gray-600 hover:bg-gray-50 focus:outline-none transition duration-150">
                                    Batal
                                </button>
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-xs font-semibold text-white bg-slate-800 hover:bg-slate-700 focus:outline-none transition duration-150">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
