@extends('admins.layouts.master')

@section('title', 'Edit Buku')

@section('beforeTitle')
<i class="fas fa-chevron-right text-gray-500 mx-2"></i>
<span class="text-gray-700">Buku</span>
@endsection

@section('content')
<div class="flex justify-center">
    <div class="bg-white shadow-lg rounded-lg p-6 w-1/2">
        <h2 class="text-2xl font-bold mb-4 text-center">Edit Buku</h2>

        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-400 text-white p-3 rounded mb-4 text-center">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('booksAdmin.update', Crypt::encryptString($book->id_buku)) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Input Judul Buku -->
            <div class="mb-4">
                <label for="judul_buku" class="block font-semibold">Judul Buku <span class="text-red-500">*</span></label>
                <input type="text" name="judul_buku" id="judul_buku" 
                       value="{{ old('judul_buku', $book->judul_buku) }}" 
                       class="w-full p-2 border rounded @error('judul_buku') border-red-500 @enderror">
                @error('judul_buku')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Input Jumlah Buku -->
            <div class="mb-4">
                <label for="jumlah_buku" class="block font-semibold">Jumlah Buku <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah_buku" id="jumlah_buku" 
                       value="{{ old('jumlah_buku', $book->jumlah_buku) }}" min="1" 
                       class="w-full p-2 border rounded @error('jumlah_buku') border-red-500 @enderror">
                @error('jumlah_buku')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Dropdown Kategori -->
            <div class="mb-4">
                <label for="id_kategori" class="block font-semibold">Kategori Buku <span class="text-red-500">*</span></label>
                <select name="id_kategori" id="id_kategori" 
                        class="w-full p-2 border rounded @error('id_kategori') border-red-500 @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id_kategori }}" 
                            {{ old('id_kategori', $book->id_kategori) == $category->id_kategori ? 'selected' : '' }}>
                            {{ $category->kategori }}
                        </option>
                    @endforeach
                </select>
                @error('id_kategori')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Tombol Submit, Reset, dan Batal -->
            <div class="flex justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Simpan Perubahan
                </button>
                <button type="reset" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Reset
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
