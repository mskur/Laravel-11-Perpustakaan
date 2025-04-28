@extends('admins.layouts.master')

@section('title', 'Manajemen User')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Daftar User</h2>

    <!-- Tombol Tambah User -->
    <div class="flex justify-between mb-4 items-center">
        <a href="{{ route('usersAdmin.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Tambah User
        </a>

        <!-- Form Pencarian -->
        <form action="{{ route('usersAdmin.index') }}" method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" placeholder="Cari User, No HP, Alamat..." 
                value="{{ request('search') }}" 
                class="border p-2 rounded-md w-64 text-lg">
            
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 text-lg flex items-center">
                <i class="fas fa-search mr-2"></i> Cari
            </button>
        </form>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabel Users -->
    <div class="bg-white rounded-lg">
        <table class="w-full text-left border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Foto</th>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Tanggal Lahir</th>
                    <th class="p-3 text-left">Alamat</th>
                    <th class="p-3 text-left">No HP</th>
                    <th class="p-3 text-left">Role</th>
                    <th class="p-3 text-left">Barcode</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="userTable">
                @forelse ($users as $index => $user)
                <tr class="border-t">
                    <td class="p-3 user-data">{{ $index + 1 }}</td>
                    <td class="p-3 user-data">
                        <img src="{{ $user->foto_user ? asset('storage/' . $user->foto_user) : 'https://ui-avatars.com/api/?name='.urlencode($user->nama_user).'&background=random' }}" 
                            alt="Foto {{ $user->nama_user }}" 
                            class="w-12 h-12 rounded-full">
                    </td>
                    <td class="p-3 user-data">{{ $user->nama_user }}</td>
                    <td class="p-3 user-data">{{ $user->tanggal_lahir }}</td>
                    <td class="p-3 user-data">{{ $user->alamat }}</td>
                    <td class="p-3 user-data">{{ $user->no_hp }}</td>
                    <td class="p-3 user-data">{{ ucfirst($user->role) }}</td>
                    <td class="p-3 user-data">
                        <img src="{{ $user->barcode_user ? asset('storage/' . $user->barcode_user) : 'https://via.placeholder.com/100x50?text=No+Barcode' }}" 
                            alt="Barcode {{ $user->id_user }}">
                    </td>
                    <td class="text-center align-middle">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('usersAdmin.edit', Crypt::encryptString($user->id_user)) }}" 
                            class="bg-yellow-500 text-white px-4 py-1 text-lg rounded-lg hover:bg-yellow-600">
                                Edit
                            </a>
                            <form action="{{ route('usersAdmin.destroy', $user->id_user) }}" method="POST" 
                                onsubmit="return confirm('Yakin hapus user {{ $user->nama_user }}?')" class="m-0 p-0 flex">
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
                    <td colspan="9" class="text-center p-4 text-gray-500">Tidak ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->appends(['search' => request('search')])->links() }}
    </div>
</div>

<!-- Live Search JavaScript -->
<script>
    document.querySelector("input[name='search']").addEventListener("keyup", function () {
        let query = this.value.toLowerCase();
        let rows = document.querySelectorAll("#userTable tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(query) ? "" : "none";
        });
    });
</script>

@endsection
