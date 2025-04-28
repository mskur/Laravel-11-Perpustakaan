<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Auth\AdminLogin;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admins.categories.viewCategory', compact('categories'));
    }

    public function create(): View
    {
        return view('admins.categories.createCategory');
    }

    public function store(Request $request) : RedirectResponse
    {
        //validate form
        $request->validate([
            'kategori' => 'required|string|max:255',
            'kode_rak' => 'nullable|string|max:255',
        ]);

        // Ambil kategori terakhir dari database berdasarkan ID Kategori
        $lastKategori = Category::orderBy('id_kategori', 'desc')->first();

        // Generate kode kategori baru
        $newCode = 'KTGR0001'; // Default jika belum ada data

        if ($lastKategori) {
            // Ambil angka dari kode terakhir, lalu tambahkan 1
            $number = (int) substr($lastKategori->id_kategori, 4) + 1;
            $newCode = 'KTGR' . str_pad($number, 4, '0', STR_PAD_LEFT);
        }

        //create product
        Category::create([
            'id_kategori' => $newCode, // Primary Key
            'kategori' => $request->kategori,
            'kode_rak' => $request->kode_rak,
        ]);

        //redirect to index
        return redirect()->route('categoryAdmin.index')->with(['success' => 'Data Kategori Berhasil Disimpan!']);
    }

    public function edit($encrypted_id) 
    {
        try {
            $getCategoryByID = Category::findOrFail(Crypt::decryptString($encrypted_id));
            $category = $getCategoryByID;

            if (!$category) {
                abort(403, 'Akses Ditolak!'); // Jika tidak ditemukan, tolak akses
            }

            //render view with category
            return view('admins.categories.editCategory', compact('category'));
        } 

        catch (\Exception $e) {
            return redirect()->route('categoryAdmin.index')->with('error', 'Kategori Gagal Diubah!');
        }
        
    }

    public function update(Request $request, $encrypted_id) : RedirectResponse
    {
        //validate form
        $request->validate([
            'kategori' => 'required|string|max:255',
            'kode_rak' => 'required|string|max:255',
        ]);

        try {
            //get by ID
            $getCategoryByID = Category::findOrFail(Crypt::decryptString($encrypted_id));
        
            $getCategoryByID->update([
                'kategori' => $request->kategori,
                'kode_rak' => $request->kode_rak,    
            ]);

            //redirect to index
            return redirect()->route('categoryAdmin.index')->with(['success' => 'Data Berhasil Diubah!']);
        }
        catch (\Exception $e) {
            return redirect()->route('categoryAdmin.index')->with('error', 'Kategori Gagal Diubah!');
        }
        
    }

    public function destroy($id_kategori) : RedirectResponse
    {
        //get product by ID
        $delCategoryByID = Category::findOrFail($id_kategori);

        //delete product
        $delCategoryByID->delete();

        //redirect to index
        return redirect()->route('categoryAdmin.index')->with(['success' => 'Data Kategori Berhasil Dihapus!']);
    }
}
