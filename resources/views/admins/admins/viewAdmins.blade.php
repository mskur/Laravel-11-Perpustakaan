@extends('admins.layouts.master')

@section('title', 'Semua Admin')

@section('content')

<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold">Daftar Admin</h3>
        <a href="{{ route('adminaction.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            + Tambah Admin
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
                <th class="py-2 px-4 border">ID Admin</th>
                <th class="py-2 px-4 border">Nama Admin</th>
                <th class="py-2 px-4 border">Role</th>
                <th class="py-2 px-4 border text-center align-middle">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $index => $admin)
                <tr class="border">
                    <td class="py-2 px-4">{{ $index + 1 }}</td>
                    <td class="py-2 px-4">{{ $admin->id_admin }}</td>
                    <td class="py-2 px-4"><p>{{ $admin->nama_admin }}</p></td>
                    <td class="py-2 px-4">{{ $admin->role }}</td>
                    <td class="text-center align-middle py-2">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('adminaction.edit', Crypt::encryptString($admin->id_admin) ) }}" 
                            class="bg-yellow-500 text-white px-4 py-1 text-lg rounded-lg hover:bg-yellow-600">
                                Edit
                            </a>
                            <form action="{{ route('adminaction.destroy', $admin->id_admin ) }}" method="POST" 
                                onsubmit="return confirm('Yakin hapus admin {{ $admin->nama_admin }}?')" 
                                class="m-0 p-0 flex">
                                @csrf
                                @method('DELETE')
                                @if(session('id_admin') !== $admin->id_admin)
                                    <button type="submit" 
                                            class="bg-red-500 text-white px-4 py-1 text-lg rounded-lg hover:bg-red-600">
                                        Hapus
                                    </button>
                                @endif
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="py-4 text-center text-gray-500">Tidak ada admin tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Pagination -->
    <div class="mt-4">
        {{ $admins->links() }}
    </div>
</div>

@endsection