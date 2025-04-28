<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Auth\AdminLogin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    // Constructor
    public function __construct()
    {
        // Hapus jika ada session milik user
        Auth::guard('web')->logout();
    }

    // Tampilkan form login
    public function showLoginAdmin()
    {
        // Jika sudah login, arahkan ke dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.adminLogin');
    }

    // Proses login
    public function loginAdmin(Request $request)
    {
        // Validasi request
        $request->validate([
            'id_admin' => 'required',
            'password' => 'required',
        ]);

        // Cek apakah admin ada di database
        if (Auth::guard('admin')->attempt(['id_admin' => $request->id_admin, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Ambil beberapa data admin
            $admin = Auth::guard('admin')->user();
            $request->session()->put('id_admin', $admin->id_admin);
            $request->session()->put('nama_admin', $admin->nama_admin);
            $request->session()->put('role', $admin->role);

            print_r($request->session()->all());    
            return redirect()->route('dashboardAdmin');
        }

        return back()->with('error', 'ID Admin atau password salah.');
    }

    // Logout
    public function logoutAdmin()
    {
        Auth::guard('admin')->logout();
        //Hapus session
        session()->flush();
        return redirect()->route('loginAdmin')->with('message', 'Berhasil logout.');
    }

    // Dashboard
    public function dashboardAdmin(Request $request)
    {
        // if (!Auth::guard('admin')->check()) {
        //     return redirect()->route('loginAdmin')->with('error', 'Silahkan login terlebih dahulu ADMIN.');
        // }
        // // print_r($request->session()->all());
        // // die();
        // return view('admins.dashboard');
        return view('admins.dashboard');
    }
}
