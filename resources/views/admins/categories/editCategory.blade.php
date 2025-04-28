<?php 

print_r($user);
die;

?>

@extends('admins.layouts.master')

@section('title', 'Edit Kategori')

@section('beforeTitle')
<i class="fas fa-chevron-right text-gray-500 mx-2"></i>
<span class="text-gray-700">Kategori</span>
@endsection

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Edit Kategori</h2>

    <form action="{{ route('categoryAdmin.update', Crypt::encryptString($category->id_kategori)) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="kategori" class="block text-gray-700">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" id="kategori" name="kategori" value="{{ old('kategori', $category->kategori) }}" class="w-full p-2 border border-gray-300 rounded-lg">
            @error('kategori')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="kode_rak" class="block text-gray-700">Kode Rak</label>
            <textarea id="kode_rak" name="kode_rak" class="w-full p-2 border border-gray-300 rounded-lg">{{ old('kode_rak', $category->kode_rak) }}</textarea>
            @error('kode_rak')
                <div class="text-red-500 bg-red-100 border border-red-400 rounded-md p-2 mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Update</button>
            <button type="reset" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Reset</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<!-- <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('kode_rak')
</script> -->
@endsection