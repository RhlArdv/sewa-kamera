@extends('layouts.app')

    @section('header')
        <h2 class="text-xl font-bold text-gray-900 font-display">
            {{ __('Kelola Pengguna') }}
        </h2>
    @endsection

@section('content')

    <div class="py-2">
        <div class="max-w-7xl mx-auto space-y-6">

            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-sm font-bold text-gray-900">Daftar Pengguna Sistem</h3>
                    <p class="text-xs text-gray-400 mt-0.5 font-sans">Daftar seluruh akun pelanggan dan admin yang terdaftar pada sistem.</p>
                </div>

                <div class="overflow-x-auto font-sans">
                    <table class="w-full text-sm text-left text-gray-650">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100 font-sans">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-center w-16">ID</th>
                                <th scope="col" class="px-6 py-3.5">Nama Lengkap</th>
                                <th scope="col" class="px-6 py-3.5">Alamat E-mail</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Role Pengguna</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Ubah Akses / Role</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50/50 transition duration-150">
                                    <td class="px-6 py-4 text-center font-medium text-gray-400">{{ $user->id }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-800">
                                        <div class="flex items-center space-x-2">
                                            <span>{{ $user->name }}</span>
                                            @if($user->id === Auth::id())
                                                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-slate-100 text-slate-700 border border-slate-200">
                                                    Anda
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-450 font-mono text-xs">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($user->role === 'admin')
                                            <span class="px-2 py-0.5 rounded text-xs font-bold bg-slate-800 text-white border border-slate-800 uppercase">
                                                Admin
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200 uppercase">
                                                Pelanggan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('menu.users.role', $user->id) }}" method="POST" class="inline-flex items-center space-x-2">
                                                @csrf
                                                <select 
                                                    name="role" 
                                                    class="bg-white border border-gray-250 rounded-lg py-1 px-3 text-xs text-gray-700 focus:outline-none focus:border-slate-500 transition duration-150"
                                                >
                                                    <option value="pelanggan" {{ $user->role === 'pelanggan' ? 'selected' : '' }}>Set Pelanggan</option>
                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Set Admin</option>
                                                </select>
                                                <button 
                                                    type="submit" 
                                                    class="inline-flex items-center px-2.5 py-1 bg-gray-100 hover:bg-slate-50 hover:text-slate-850 text-gray-600 text-xs font-semibold rounded-lg transition duration-150 border border-transparent hover:border-slate-200"
                                                >
                                                    Terapkan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Tidak dapat mengubah role sendiri</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
