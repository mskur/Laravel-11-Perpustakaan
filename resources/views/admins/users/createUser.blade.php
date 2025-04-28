@extends('admins.layouts.master')

@section('title', 'Tambah User')

@section('beforeTitle')
<i class="fas fa-chevron-right text-gray-500 mx-2"></i>
<span class="text-gray-700">User</span>
@endsection

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Tambah User</h2>

    <form action="{{ route('usersAdmin.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Nama User -->
        <div class="mb-4">
            <label for="nama_user" class="block text-gray-700">Nama User <span class="text-red-500">*</span></label>
            <input type="text" id="nama_user" name="nama_user" value="{{ old('nama_user') }}" class="w-full p-2 border border-gray-300 rounded-lg">
            @error('nama_user')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tanggal Lahir -->
        <div class="mb-4">
            <label for="tanggal_lahir" class="block text-gray-700">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full p-2 border border-gray-300 rounded-lg">
            @error('tanggal_lahir')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Alamat -->
        <div class="mb-4">
            <label for="alamat" class="block text-gray-700">Alamat</label>
            <textarea id="alamat" name="alamat" class="w-full p-2 border border-gray-300 rounded-lg">{{ old('alamat') }}</textarea>
            @error('alamat')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- No HP -->
        <div class="mb-4">
            <label for="no_hp" class="block text-gray-700">Nomor HP</label>
            <input type="text" id="no_hp" name="no_hp" 
                value="{{ old('no_hp') }}" 
                class="w-full p-2 border border-gray-300 rounded-lg" 
                placeholder="Contoh: 081234567890"
                pattern="08[0-9]{8,11}"
                title="Nomor HP harus dimulai dengan 08 dan memiliki panjang 10-13 digit">
            @error('no_hp')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password <span class="text-red-500">*</span></label>
            <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded-lg">
            @error('password')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Foto User -->
        <div class="mb-4">
            <label for="foto_user" class="block text-gray-700">Foto User</label>
            <input type="file" id="foto_user" name="foto_user" class="w-full p-2 border border-gray-300 rounded-lg">
            @error('foto_user')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Simpan</button>
            <button type="reset" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Reset</button>
        </div>
    </form>
</div>
@endsection
