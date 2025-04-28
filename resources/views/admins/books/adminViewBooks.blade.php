@extends('admins.layouts.master')

@section('title', 'Manajemen Buku')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Daftar Buku</h2>

    <!-- Tombol Tambah Buku -->
    <div class="flex justify-between mb-4 items-center">
        <!-- Tombol Tambah Buku -->
        <a href="{{ route('booksAdmin.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            + Tambah Buku
        </a>

        <!-- Form Pencarian -->
        <form action="{{ route('booksAdmin.index') }}" method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" placeholder="Cari Buku, Kategori, atau Rak..." 
                value="{{ request('search') }}" 
                class="border p-2 rounded-md w-64 text-lg">

            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 text-lg flex items-center">
                <i class="fas fa-search mr-2"></i> Cari
            </button>
        </form>
    </div>



    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabel Buku -->
    <div class="bg-white rounded-lg">
        <table class="w-full text-left border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Judul Buku</th>
                    <th class="p-3 text-left">Jumlah</th>
                    <th class="p-3 text-left">Kategori</th>
                    <th class="p-3 text-left">Barcode</th>
                    <th class="p-3 text-left">Rak</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="bookTable">
                @forelse ($books as $index => $book)
                <tr class="border-t">
                    <td class="p-3 book-data">{{ $index + 1 }}</td>
                    <td class="p-3 book-data">{{ $book->judul_buku }}</td>
                    <td class="p-3 book-data">{{ $book->jumlah_buku }}</td>
                    <td class="p-3 book-data">{{ $book->category->kategori }}</td>
                    <td class="p-3 book-data">
                        <img src="{{ asset('storage/' . $book->barcode_buku) }}" alt="Barcode {{ $book->id_buku }}">
                    </td>
                    <td class="p-3 book-data">{{ $book->category->kode_rak }}</td>
                    <td class="text-center align-middle">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('booksAdmin.edit', Crypt::encryptString($book->id_buku)) }}" 
                            class="bg-yellow-500 text-white px-4 py-1 text-lg rounded-lg hover:bg-yellow-600">
                                Edit
                            </a>
                            <form action="{{ route('booksAdmin.destroy', $book->id_buku) }}" method="POST" 
                                onsubmit="return confirm('Yakin hapus buku {{ $book->judul_buku }}?')" class="m-0 p-0 flex">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-1 text-lg rounded-lg hover:bg-red-600">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center p-4 text-gray-500">Tidak ada data buku.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $books->appends(['search' => request('search')])->links() }}
    </div>
</div>

<!-- Live Search JavaScript -->
<script>
    document.getElementById("search").addEventListener("keyup", function () {
        let query = this.value.toLowerCase();
        let rows = document.querySelectorAll("#bookTable tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(query) ? "" : "none";
        });
    });
</script>

@endsection
