@extends('admins.layouts.master')

@section('title', 'Data Peminjaman')

@section('content')
<style>
    [x-cloak] { display: none !important; }
</style>

<div class="p-6 bg-white rounded shadow" x-data="{ open: false, selectedLoan: null }">
    <div class="mb-4">
    <h2 class="text-2xl font-bold mb-3">Data Peminjaman</h2>

        <div class="flex justify-between items-center space-x-4">
            <!-- Tombol Tambah di kiri -->
            <a href="{{ route('loansAdmin.create') }}" 
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded whitespace-nowrap">
            + Tambah Peminjaman
            </a>

            <!-- Search Bar di kanan -->
            <form method="GET" action="{{ route('loansAdmin.index') }}" class="flex space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID / Nama User..." 
                    class="border p-2 rounded" />
            <button type="submit" 
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded whitespace-nowrap">
                Cari
            </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="p-3 mb-4 bg-green-200 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 border border-gray-300">No</th>
                    <th class="p-3 border border-gray-300">ID Peminjaman</th>
                    <th class="p-3 border border-gray-300">User</th>
                    <th class="p-3 border border-gray-300">Tanggal Pinjam</th>
                    <th class="p-3 border border-gray-300">Tanggal Kembali</th>
                    <th class="p-3 border border-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($loans as $loan)
                    <tr class="border-t border-gray-300">
                        <td class="p-3 border border-gray-300">{{ $loop->iteration + ($loans->currentPage() - 1) * $loans->perPage() }}</td>
                        <td class="p-3 border border-gray-300">{{ $loan->id_peminjaman }}</td>
                        <td class="p-3 border border-gray-300">{{ $loan->user->nama_user ?? '-' }}</td>
                        <td class="p-3 border border-gray-300">{{ $loan->tanggal_pinjam }}</td>
                        <td class="p-3 border border-gray-300">{{ $loan->tanggal_kembali }}</td>
                        <td class="p-3 border border-gray-300 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Tombol Detail -->
                                <button
                                    type="button"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 h-10 rounded text-sm font-medium flex items-center justify-center"
                                    @click="open = true; selectedLoan = {{ json_encode($loan) }}"
                                >
                                    Detail
                                </button>

                                <!-- Form Return -->
                                <form
                                    action=""
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin mengembalikan peminjaman ini?')"
                                    class="m-0"
                                    style="display: inline-flex;"
                                >
                                    @csrf
                                    @method('PUT')
                                    <button
                                        type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 h-10 rounded text-sm font-medium flex items-center justify-center"
                                        style="margin:0;"
                                    >
                                        Return
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500">
                            Belum ada Peminjaman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $loans->links() }}
    </div>

    <!-- Modal -->
    <div
        x-show="open"
        x-cloak
        x-transition
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        @click.self="open = false"
    >
        <div
            class="bg-white rounded-lg shadow-lg w-full max-w-3xl max-h-[80vh] overflow-y-auto p-6"
            @keydown.escape.window="open = false"
        >
            <h3 class="text-xl font-semibold mb-4 border-b pb-2">Detail Peminjaman</h3>

            <template x-if="selectedLoan">
                <div>
                    <table class="w-full mb-6 text-left">
                        <tbody>
                            <tr><th class="py-1 px-2 font-semibold">ID Peminjaman</th><td class="py-1 px-2" x-text="selectedLoan.id_peminjaman"></td></tr>
                            <tr><th class="py-1 px-2 font-semibold">ID User</th><td class="py-1 px-2" x-text="selectedLoan.id_user"></td></tr>
                            <tr><th class="py-1 px-2 font-semibold">ID Admin</th><td class="py-1 px-2" x-text="selectedLoan.id_admin"></td></tr>
                            <tr><th class="py-1 px-2 font-semibold">Tanggal Pinjam</th><td class="py-1 px-2" x-text="selectedLoan.tanggal_pinjam"></td></tr>
                            <tr><th class="py-1 px-2 font-semibold">Tanggal Kembali</th><td class="py-1 px-2" x-text="selectedLoan.tanggal_kembali"></td></tr>
                            <tr><th class="py-1 px-2 font-semibold">Dibuat</th><td class="py-1 px-2" x-text="selectedLoan.created_at"></td></tr>
                            <tr><th class="py-1 px-2 font-semibold">Diupdate</th><td class="py-1 px-2" x-text="selectedLoan.updated_at"></td></tr>
                        </tbody>
                    </table>

                    <h4 class="text-lg font-semibold mb-2 border-b pb-1">Detail Buku:</h4>
                    <table class="w-full border border-gray-300 text-left">
                        <thead>
                            <tr class="bg-gray-100 border-b border-gray-300">
                                <th class="p-2 border-r border-gray-300">Judul Buku</th>
                                <th class="p-2 border-gray-300">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-if="selectedLoan.details && selectedLoan.details.length > 0">
                                <template x-for="detail in selectedLoan.details" :key="detail.id_detail_peminjaman">
                                    <tr class="border-t border-gray-300">
                                        <td class="p-2 border-r border-gray-300" x-text="detail.book ? detail.book.judul_buku : 'Buku tidak ditemukan'"></td>
                                        <td class="p-2" x-text="detail.jumlah"></td>
                                    </tr>
                                </template>
                            </template>
                            <template x-if="!selectedLoan.details || selectedLoan.details.length === 0">
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
