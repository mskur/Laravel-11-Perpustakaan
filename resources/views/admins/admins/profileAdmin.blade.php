@extends('admins.layouts.master')

@section('title', 'Profil Admin')

@section('content')
<div class="flex justify-center">
    <div class="bg-white shadow-lg rounded-lg p-6 w-1/2">
        <h2 class="text-2xl font-bold mb-4 text-center">Edit Profil</h2>

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

        <form action="{{ route('updateProfile') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="id_admin" class="block font-semibold">ID Admin</label>
                <input type="text" name="id_admin" id="id_admin" value="{{ old('id_admin', $admin->id_admin) }}" class="w-full p-2 border rounded bg-gray-200" readonly>
            </div>

            <div class="mb-4">
                <label for="role" class="block font-semibold">Role</label>
                <input type="text" name="role" id="role" value="{{ old('role', $admin->role) }}" class="w-full p-2 border rounded bg-gray-200" readonly>
            </div>

            <div class="mb-4">
                <label for="nama_admin" class="block font-semibold">Nama Admin</label>
                <input type="text" name="nama_admin" id="nama_admin" value="{{ old('nama_admin', $admin->nama_admin) }}" class="w-full p-2 border rounded" >
                @error('nama_admin')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">
                    {{ $message }}
                </div>
            @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block font-semibold">Password Baru</label>
                <input type="password" name="password" id="password" class="w-full p-2 border rounded">
                <p class="text-sm text-gray-500">Kosongkan jika tidak ingin mengubah password.</p>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Update Profil</button>
        </form>
    </div>
</div>
@endsection
