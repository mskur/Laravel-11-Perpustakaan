<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Auth\AdminLogin;
use App\Models\Admin\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Storage;

class UsersAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::where('nama_user', 'like', "%$search%")
            ->orWhere('no_hp', 'like', "%$search%")
            ->orWhere('alamat', 'like', "%$search%")
            ->orWhere('role', 'like', "%$search%")
            ->paginate(3);

        return view('admins.users.viewUsers', compact('users'));
    }

    public function create() : View
    {
        return view('admins.users.createUser');
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:500',
            'no_hp' => ['required', 'regex:/^08[0-9]{8,11}$/'],
            'password' => 'required|min:3',
            'foto_user' => 'required|image|mimes:jpeg,png,jpg|max:5096', // Optional
        ]);

        /// Ambil user terakhir
        $lastUser = User::orderBy('id_user', 'desc')->first();

        // Generate ID User baru
        $newId = 'USER00001'; // Default jika belum ada user
        if ($lastUser) {
            $number = (int) substr($lastUser->id_user, 4) + 1;
            $newId = 'USER' . str_pad($number, 5, '0', STR_PAD_LEFT);
        }

        $fotoPath = null;
        if ($request->hasFile('foto_user')) {
            $fotoFile = $request->file('foto_user');
            $fotoName = $newId . '.' . $fotoFile->getClientOriginalExtension(); // Contoh: USER00001.jpg
            $fotoPath = 'fotoUser/' . $fotoName;
            Storage::disk('public')->put($fotoPath, file_get_contents($fotoFile));
        }

        // Generate Barcode untuk User
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($newId, $generator::TYPE_CODE_128);
        $barcodePath = "barcodeUser/{$newId}.png";
        Storage::disk('public')->put($barcodePath, $barcode);

        // Simpan User ke Database
        User::create([
            'id_user' => $newId,
            'nama_user' => $request->nama_user,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'password' => bcrypt($request->password), 
            'foto_user' => $fotoPath, // Nama foto sesuai ID user
            'barcode_user' => $barcodePath, // Simpan path barcode
        ]);

        return redirect()->route('usersAdmin.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($encrypted_id) 
    {
        try {
            $getUserByID = User::findOrFail(Crypt::decryptString($encrypted_id));
            $user = $getUserByID;

            if (!$user) {
                abort(403, 'Akses Ditolak!'); // Jika tidak ditemukan, tolak akses
            }

            //render view with category
            return view('admins.users.editUser', compact('user'));
        } 

        catch (\Exception $e) {
            return redirect()->route('usersAdmin.index')->with('error', 'User Gagal Diubah!');
        }
        
    }

    public function update(Request $request, $encrypted_id) : RedirectResponse
    {
        // Validasi input
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:500',
            'no_hp' => 'required|regex:/^08[0-9]{8,11}$/',
            'password' => 'nullable|min:3',
            'foto_user' => 'nullable|image|mimes:jpeg,png,jpg|max:5096',
        ]);

        try {
            // Dekripsi ID dan cari user
            $userId = Crypt::decryptString($encrypted_id);
            $user = User::findOrFail($userId);

            // Update data user
            $user->update([
                'nama_user' => $request->nama_user,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);

            // Jika password diisi, update password
            if ($request->filled('password')) {
                $user->update(['password' => bcrypt($request->password)]);
            }

            // Jika ada foto baru, update foto
            if ($request->hasFile('foto_user')) {
                // Hapus foto lama jika ada
                if ($user->foto_user) {
                    Storage::disk('public')->delete($user->foto_user);
                }

                // Simpan foto baru
                $fotoPath = $request->file('foto_user')->storeAs(
                    'fotoUser', $user->id_user . '.' . $request->file('foto_user')->getClientOriginalExtension(),
                    'public'
                );

                $user->update(['foto_user' => $fotoPath]);
            }

            if (!Storage::disk('public')->exists($user->barcode_user)) {
                // Generate ulang barcode
                $generator = new BarcodeGeneratorPNG();
                $barcode = $generator->getBarcode($user->id_user, $generator::TYPE_CODE_128);
            
                // Simpan barcode sebagai gambar
                $barcodePath = "barcodeUser/{$user->id_user}.png";
                Storage::disk('public')->put($barcodePath, $barcode);
            
                // Update path barcode di database
                $user->update(['barcode_user' => $barcodePath]);
            }

            return redirect()->route('usersAdmin.index')->with(['success' => 'User berhasil diperbarui!']);
        } 
        catch (\Exception $e) {
            return redirect()->route('usersAdmin.index')->with(['error' => 'User gagal diperbarui!']);
        }
    }

    public function destroy($id_user) : RedirectResponse
    {
        try {
            // Cari user berdasarkan ID
            $user = User::findOrFail($id_user);

            // Hapus foto user jika ada
            if ($user->foto_user && Storage::disk('public')->exists($user->foto_user)) {
                Storage::disk('public')->delete($user->foto_user);
            }

            // Hapus barcode user jika ada
            if ($user->barcode_user && Storage::disk('public')->exists($user->barcode_user)) {
                Storage::disk('public')->delete($user->barcode_user);
            }

            // Hapus user dari database
            $user->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('usersAdmin.index')->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('usersAdmin.index')->with('error', 'Gagal menghapus user!');
        }
    }

}
