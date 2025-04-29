@extends('admins.layouts.master')

@section('title', 'Data Pengembalian')

@section('content')

<style>
    [x-cloak] { display: none !important; }
</style>

<div class="p-6 bg-white rounded shadow" x-data="{ open: false, selectedReturn: null }">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Data Pengembalian</h2>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('returnsAdmin.index') }}" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID / Nama User..." 
                class="border p-2 rounded" />
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                Cari
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="p-3 mb-4 bg-green-200 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 border">No</th>
                    <th class="p-3 border">ID Pengembalian</th>
                    <th class="p-3 border">User</th>
                    <th class="p-3 border">Tanggal Pengembalian</th>
                    <th class="p-3 border">Denda</th>
                    <th class="p-3 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($returns as $return)
                    <tr>
                        <td class="p-3 border">{{ $loop->iteration + ($returns->currentPage() - 1) * $returns->perPage() }}</td>
                        <td class="p-3 border">{{ $return->id_pengembalian }}</td>
                        <td class="p-3 border">{{ $return->loan->user->nama_user ?? '-' }}</td>
                        <td class="p-3 border">{{ $return->tanggal_pengembalian }}</td>
                        <td class="p-3 border">Rp {{ number_format($return->denda, 0, ',', '.') }}</td>
                        <td class="p-3 border text-center">
                            <button
                                type="button"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm"
                                @click="open = true; selectedReturn = {{ json_encode($return) }}"
                            >
                                Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-6 text-center text-gray-500">Belum ada Pengembalian.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $returns->links() }}
    </div>

    <!-- Modal -->
    <div
        x-show="open"
        x-cloak
        x-transition
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        @click.self="open = false"
    >
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl max-h-[80vh] overflow-y-auto p-6">
            <h3 class="text-xl font-semibold mb-4">Detail Pengembalian</h3>

            <template x-if="selectedReturn">
                <div>
                    <table class="w-full mb-6 text-left">
                        <tbody>
                            <tr><th class="py-1 px-2 font-semibold">ID Pengembalian</th><td class="py-1 px-2" x-text="selectedReturn.id_pengembalian"></td></tr>
                            <tr><th class="py-1 px-2 font-semibold">ID Peminjaman</th><td class="py-1 px-2" x-text="selectedReturn.id_peminjaman"></td></tr>
                            <tr><th class="py-1 px-2 font-semibold">Tanggal Pengembalian</th><td class="py-1 px-2" x-text="selectedReturn.tanggal_pengembalian"></td></tr>
                            <tr><th class="py-1 px-2 font-semibold">Denda</th><td class="py-1 px-2">Rp <span x-text="selectedReturn.denda"></span></td></tr>
                        </tbody>
                    </table>

                    <h4 class="text-lg font-semibold mb-2">Detail Buku:</h4>
                    <table class="w-full border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-2 border">Judul Buku</th>
                                <th class="p-2 border">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-if="selectedReturn.details && selectedReturn.details.length > 0">
                                <template x-for="detail in selectedReturn.details" :key="detail.id_detail_pengembalian">
                                    <tr>
                                        <td class="p-2 border" x-text="detail.book ? detail.book.judul_buku : 'Buku tidak ditemukan'"></td>
                                        <td class="p-2 border" x-text="detail.jumlah"></td>
                                    </tr>
                                </template>
                            </template>
                            <template x-if="!selectedReturn.details || selectedReturn.details.length === 0">
                                <tr>
                                    <td colspan="2" class="p-2 text-center text-gray-500">Tidak ada detail buku.</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </template>

            <div class="mt-6 text-right">
                <button
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded"
                    @click="open = false"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
