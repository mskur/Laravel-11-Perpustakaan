<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Auth\AdminLogin;
use App\Models\Admin\Admin;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class AdminController extends Controller
{
    public function confirmationSuperAdmin ()
    {
        $id_admin = session('id_admin');
        $admin = Admin::findOrFail($id_admin);

        // Ambil role dari database
        $role = $admin->role;

        if($role !== 'superadmin') {
            return redirect()->route('getAdmin')->with('error', 'Menu Khusus Superadmin!');
        }

        return null;
    }

    public function index() : View
    {
        // $id_admin = session('id_admin');
        // $admin = Admin::findOrFail($id_admin);

        // // Ambil role dari database
        // $role = $admin->role;

        // if($role !== 'superadmin') {
        //     return redirect()->route('getAdmin')->with('error', 'Menu Khusus Superadmin!');
        // }
        $redirect = $this->confirmationSuperAdmin();
        if ($redirect) return $redirect; // Jika bukan superadmin, langsung redirect

        $admins = Admin::latest()->paginate(10);

        // Return the view with the products
        return view('admins.admins.viewAdmins', compact('admins'));
    }

    public function create(): View
    {
        $redirect = $this->confirmationSuperAdmin();
        if ($redirect) return $redirect; // Jika bukan superadmin, langsung redirect

        // Return the view
        return view('admins.admins.createAdmin');
    }

    public function store(Request $request) : RedirectResponse
    {
        $redirect = $this->confirmationSuperAdmin();
        if ($redirect) return $redirect; // Jika bukan superadmin, langsung redirect

        //validate form
        $request->validate([
            'nama_admin' => 'required|string|max:25',
            'password' => 'required|string',
            'role' => 'required|in:admin,superadmin',
        ]);

        // Ambil admin terakhir dari database berdasarkan ID 
        $lastAdmin = Admin::orderBy('id_admin', 'desc')->first();

        // Generate kode kategori baru
        $newCode = 'ADMIN0001'; // Default jika belum ada data

        if ($lastAdmin) {
            // Ambil angka dari kode terakhir, lalu tambahkan 1
            $number = (int) substr($lastAdmin->id_admin, 5) + 1;
            $newCode = 'ADMIN' . str_pad($number, 4, '0', STR_PAD_LEFT);
        }

        Admin::create([
            'id_admin' => $newCode,
            'nama_admin' => $request->nama_admin,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        //redirect to index
        return redirect()->route('adminaction.index')->with(['success' => 'Data Admin Berhasil Disimpan!']);
    }

    public function edit($encrypted_id)
    {
        $redirect = $this->confirmationSuperAdmin();
        if ($redirect) return $redirect; // Jika bukan superadmin, langsung redirect

        try {
            $getAdminByID = Admin::findOrFail(Crypt::decryptString($encrypted_id));
            $admin = $getAdminByID;

            if (!$admin) {
                abort(403, 'Akses Ditolak!'); // Jika tidak ditemukan, tolak akses
            }

            //render view with admin
            return view('admins.admins.editAdmin', compact('admin'));
        }
        catch (\Exception $e) {
            return redirect()->route('adminaction.index')->with('error', 'Data Admin Gagal Diubah!');
        }
    }

    public function update(Request $request, $encrypted_id): RedirectResponse
    {
        $redirect = $this->confirmationSuperAdmin();
        if ($redirect) return $redirect; // Jika bukan superadmin, langsung redirect
        
        //validate form
        $request->validate([
            'nama_admin' => 'required|string|max:25',
            'password' => 'nullable|string',
            'role' => 'required|in:admin,superadmin',
        ]);

        try {
            $getAdminByID = Admin::findOrFail(Crypt::decryptString($encrypted_id));
            $admin = $getAdminByID;

            if (session('id_admin') == $admin->id_admin && $request->role !== session('role')) {
                return redirect()->route('adminaction.index')->with(['error' => 'Anda sedang login, Dilarang mengubah role!']);
            }

            if ($request->password) {
                $admin->update([
                    'nama_admin' => $request->nama_admin,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                ]);
            }
            else {
                $admin->update([
                    'nama_admin' => $request->nama_admin,
                    'role' => $request->role,
                ]);
            }
            
            if (session('id_admin') == $admin->id_admin) {
                session()->put([
                    'nama_admin' => $request->nama_admin
                ]);
            }
            
            return redirect()->route('adminaction.index')->with(['success' => 'Data Admin Berhasil Diubah!']);
        }
        catch (\Exception $e) {
            return redirect()->route('adminaction.index')->with('error', 'Data Admin Gagal Diubah!');
        }
        
    }

    public function destroy($id_admin): RedirectResponse
    {
        $redirect = $this->confirmationSuperAdmin();
        if ($redirect && ($id_admin === session('id_admin'))) {
            return $redirect; // Jika bukan superadmin, langsung redirect
        }

        $getAdminByID = Admin::findOrFail($id_admin);
        $getAdminByID->delete();

        //redirect to index
        return redirect()->route('adminaction.index')->with(['success' => 'Data Admin Berhasil Dihapus!']);
    }

    public function getAdmin() : View
    {
        $id_admin = session('id_admin');

        if (!$id_admin) {
            abort(403, 'Unauthorized access.');
        }

        $admin = Admin::findOrFail(session('id_admin'));
        return view('admins.admins.profileAdmin', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $id_admin = session('id_admin');

        if (!$id_admin) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'nama_admin' => 'required|string|max:25',
            'password' => 'nullable',
        ]);

        $admin = Admin::findOrFail(session('id_admin'));

        // Update Nama Admin
        $admin->nama_admin = $request->nama_admin;

        // Update Password Jika Diisi
        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        session()->put([
            'nama_admin' => $admin->nama_admin
        ]);

        return redirect()->route('getAdmin')->with('success', 'Profil berhasil diperbarui.');
    }


}
