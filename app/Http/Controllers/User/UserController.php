<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function getUser() : View
    {
        $id_user = session('id_user');

        if (!$id_user) {
            abort(403, 'Unauthorized access.');
        }

        $user = User::findOrFail(session('id_user'));
        return view('users.profileUser', compact('user'));
    }

    public function updateProfileUser(Request $request)
    {
        $id_user = session('id_user');

        if (!$id_user) {
            abort(403, 'Unauthorized access.');
        }

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
            $user = User::findOrFail($id_user);

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

            session()->put([
                'nama_user' => $user->nama_user,
                'foto_user' => $user->foto_user
            ]);

            return redirect()->route('getUser')->with(['success' => 'Profil berhasil diperbarui!']);
        } 
        catch (\Exception $e) {
            return redirect()->route('getUser')->with(['error' => 'Profil gagal diperbarui!']);
        }
    }
}
