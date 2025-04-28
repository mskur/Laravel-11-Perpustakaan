@extends('admins.layouts.master')

@section('title', 'Peminjaman Baru')

@section('beforeTitle')
<i class="fas fa-chevron-right text-gray-500 mx-2"></i>
<span class="text-gray-700">Peminjaman</span>
@endsection

@section('content')
<div class="p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Form Peminjaman</h2>

    @if(session('error'))
        <div class="p-3 mb-4 bg-red-200 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="p-3 mb-4 bg-green-200 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <form action="{{ route('loansAdmin.store') }}" method="POST" id="loanForm">
        @csrf

        <!-- ID Admin (hidden) -->
        <input type="hidden" name="id_admin" value="{{ auth()->guard('admin')->user()->id_admin }}">

        <!-- ID User -->
        <div class="mb-4">
            <label class="block mb-1">ID User</label>
            <input type="text" name="id_user" id="id_user" class="w-full border p-2 rounded" required>
            @error('id_user')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Tanggal Pinjam -->
        <div class="mb-4">
            <label class="block mb-1">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="w-full border p-2 rounded" required>
            @error('tanggal_pinjam')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Tanggal Kembali (readonly) -->
        <div class="mb-4">
            <label class="block mb-1">Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="w-full border p-2 rounded bg-gray-100" readonly required>
            @error('tanggal_kembali')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Buku -->
        <div class="mb-4">
            <label class="block mb-1">Pilih Buku</label>
            <div id="book-list">
                <div class="flex space-x-2 mb-2">
                    <select name="books[0][id_buku]" class="border p-2 rounded w-2/3">
                        @foreach($books as $book)
                            <option value="{{ $book->id_buku }}">{{ $book->judul_buku }} (Stok: {{ $book->jumlah_buku }})</option>
                        @endforeach
                    </select>
                    <input type="number" name="books[0][jumlah]" min="1" class="border p-2 rounded w-1/3" placeholder="Jumlah" required>
                </div>
            </div>

            <button type="button" onclick="addBook()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-2">Tambah Buku</button>
        </div>

        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">Simpan Peminjaman</button>
    </form>
</div>

<script>
let bookIndex = 1;

// Simpan data books dalam JavaScript
const booksOptions = `
    @foreach($books as $book)
        <option value="{{ $book->id_buku }}">{{ $book->judul_buku }} (Stok: {{ $book->jumlah_buku }})</option>
    @endforeach
`;

// Auto generate tanggal kembali
document.getElementById('tanggal_pinjam').addEventListener('change', function() {
    const tanggalPinjam = new Date(this.value);
    if (!isNaN(tanggalPinjam.getTime())) {
        tanggalPinjam.setDate(tanggalPinjam.getDate() + 7);
        const year = tanggalPinjam.getFullYear();
        const month = String(tanggalPinjam.getMonth() + 1).padStart(2, '0');
        const day = String(tanggalPinjam.getDate()).padStart(2, '0');
        document.getElementById('tanggal_kembali').value = `${year}-${month}-${day}`;
    }
});

// Tambah pilihan buku baru
function addBook() {
    const bookList = document.getElementById('book-list');
    const newRow = document.createElement('div');
    newRow.className = 'flex space-x-2 mb-2';
    newRow.innerHTML = `
        <select name="books[${bookIndex}][id_buku]" class="border p-2 rounded w-2/3">
            ${booksOptions}
        </select>
        <input type="number" name="books[${bookIndex}][jumlah]" min="1" class="border p-2 rounded w-1/3" placeholder="Jumlah" required>
    `;
    bookList.appendChild(newRow);
    bookIndex++;
}
</script>
@endsection
