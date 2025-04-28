@extends('admins.layouts.master')

@section('title', 'Tambah Admin')

@section('beforeTitle')
<i class="fas fa-chevron-right text-gray-500 mx-2"></i>
<span class="text-gray-700">Admin</span>
@endsection

@section('content')
<div class="flex justify-center">
    <div class="bg-white shadow-lg rounded-lg p-6 w-1/2">
        <h2 class="text-2xl font-bold mb-4 text-center">Tambah Admin</h2>

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

        <form action="{{ route('adminaction.store') }}" method="POST">
            @csrf

            <!-- Dropdown Role -->
            <div class="mb-4">
                <label for="role" class="block font-semibold">Role</label>
                <select name="role" id="role" class="w-full p-2 border rounded">
                    <option value="admin" {{ old('role', 'admin') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                </select>
                @error('role')
                    <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Nama Admin -->
            <div class="mb-4">
                <label for="nama_admin" class="block font-semibold">Nama Admin</label>
                <input type="text" name="nama_admin" id="nama_admin" value="{{ old('nama_admin') }}" class="w-full p-2 border rounded" >
                @error('nama_admin')
                    <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block font-semibold">Password</label>
                <input type="password" name="password" id="password" class="w-full p-2 border rounded" >
                @error('password')
                    <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Tombol Submit & Reset -->
            <div class="flex justify-between">
                <button type="reset" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600">
                    Reset
                </button>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                    Tambah Admin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
