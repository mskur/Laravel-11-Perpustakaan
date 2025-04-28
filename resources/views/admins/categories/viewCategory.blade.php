@extends('admins.layouts.master')

@section('title', 'Kategori')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold">Daftar Kategori</h3>
        <a href="{{ route('categoryAdmin.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            + Tambah Kategori
        </a>
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

    <table class="w-full text-left border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-2 px-4 border">No</th>
                <th class="py-2 px-4 border">Nama Kategori</th>
                <th class="py-2 px-4 border">Kode Rak</th>
                <th class="py-2 px-4 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $index => $category)
                <tr class="border">
                    <td class="py-2 px-4">{{ $index + 1 }}</td>
                    <td class="py-2 px-4">{{ $category->kategori }}</td>
                    <td class="py-2 px-4"><p>{!! $category->kode_rak !!}</p></td>
                    <td class="text-center align-middle py-2">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('categoryAdmin.edit', Crypt::encryptString($category->id_kategori)) }}" 
                            class="bg-yellow-500 text-white px-4 py-1 text-lg rounded-lg hover:bg-yellow-600">
                                Edit
                            </a>
                            <form action="{{ route('categoryAdmin.destroy', $category->id_kategori) }}" method="POST" 
                                onsubmit="return confirm('Yakin hapus kategori {{ $category->kategori }}?')" class="m-0 p-0 flex">
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
                    <td colspan="3" class="py-4 text-center text-gray-500">Tidak ada kategori tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Pagination -->
    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection
