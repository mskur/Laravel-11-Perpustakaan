<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Auth\UserLogin;
use Illuminate\Support\Facades\Log;

class UserLoginController extends Controller
{
    // Constructor
    public function __construct()
    {
        // Hapus jika ada session milik admin
        Auth::guard('admin')->logout();
    }
    
    public function showLoginUser()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.userLogin');
    }

    public function loginUser(Request $request)
    {
        session()->flush();
        // Validasi request
        $request->validate([
            'id_user' => 'required',
            'password' => 'required',
        ]);

        // Cek apakah user ada di database
        if (Auth::guard('web')->attempt(['id_user' => $request->id_user, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Ambil beberapa data admin
            $user = Auth::guard('web')->user();
            $request->session()->put('id_user', $user->id_user);
            $request->session()->put('nama_user', $user->nama_user);
            $request->session()->put('foto_user', $user->foto_user);
            $request->session()->put('role', $user->role);

            return redirect()->route('dashboard');
        }

        return back()->with('error', 'ID User atau password salah.');
    }

    public function logoutUser()
    {
        Auth::guard('web')->logout();
        //Hapus session
        session()->flush();
        return redirect()->route('loginUser')->with('message', 'Berhasil logout.');
    }

    public function dashboard(Request $request)
    {
        if (!Auth::check()) {
            // Cetak isi session dengan print_r

            print_r($request->session()->all());

            // Jika belum login, arahkan ke login
            return redirect()->route('loginUser')->with('error', 'Silahkan login terlebih dahulu USER.');
        }
        return view('users.dashboard');
    }
}
