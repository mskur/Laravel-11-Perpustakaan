<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Ensure this is the correct Controller class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Auth\AdminLogin;
use App\Models\Category;
use App\Models\Book;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Storage;

class BooksAdminController extends Controller
{
    // Constructor
    public function __construct()
    {
        
    }

    // Display a listing of the resource.
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Book::with('category')->orderBy('judul_buku', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%$search%")
                ->orWhere('jumlah_buku', 'like', "%$search%")
                ->orWhere('barcode_buku', 'like', "%$search%")
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('kategori', 'like', "%$search%")
                        ->orWhere('kode_rak', 'like', "%$search%");
                });
            });
        }

        $books = $query->paginate(3)->appends(['search' => $search]);
        $categories = Category::all();

        return view('admins.books.adminViewBooks', compact('books', 'categories', 'search'));
    }

    // Show the form for creating a new resource.
    public function create() : View
    {
        $categories = Category::all();
        return view('admins.books.createBook', compact('categories'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'jumlah_buku' => 'required|integer|min:1',
            'id_kategori' => 'required|exists:categories,id_kategori',
        ]);

        // Ambil buku terakhir
        $lastBook = Book::orderBy('id_buku', 'desc')->first();

        // Generate ID Buku baru
        $newId = 'BOOK0001'; // Default jika belum ada buku
        if ($lastBook) {
            $number = (int) substr($lastBook->id_buku, 4) + 1;
            $newId = 'BOOK' . str_pad($number, 4, '0', STR_PAD_LEFT);
        }

        // Generate Barcode
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($newId, $generator::TYPE_CODE_128);

        // Simpan barcode sebagai gambar di public/barcodeBuku/
        $barcodePath = "barcodeBuku/{$newId}.png";

        Book::create([
            'id_buku' => $newId,
            'judul_buku' => $request->judul_buku,
            'jumlah_buku' => $request->jumlah_buku,
            'id_kategori' => $request->id_kategori,
            'barcode_buku' => $barcodePath, // Simpan path barcode
        ]);

        Storage::disk('public')->put($barcodePath, $barcode);
        return redirect()->route('booksAdmin.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    // Display the specified resource.
    public function show($id)
    {
        // ...code to show a specific book...
    }

    // Show the form for editing the specified resource.
    public function edit($encrypted_id)
    {
        try {
            $getBookByID = Book::findOrFail(Crypt::decryptString($encrypted_id));
            $book = $getBookByID;

            if (!$book) {
                abort(403, 'Akses Ditolak!'); // Jika tidak ditemukan, tolak akses
            }

            $categories = Category::all();
            //render view with category
            return view('admins.books.editBook', [
                'book' => $book,
                'categories' => $categories
            ]);
        } 

        catch (\Exception $e) {
            return redirect()->route('booksAdmin.index')->with('error', 'Data Buku Gagal Diubah!');
        }
    }

    // Update the specified resource in storage.
    public function update(Request $request, $encrypted_id) : RedirectResponse
    {
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'jumlah_buku' => 'required|integer|min:1',
            'id_kategori' => 'required|exists:categories,id_kategori',
        ]);

        try {
            $getBookByID = Book::findOrFail(Crypt::decryptString($encrypted_id));
            $book = $getBookByID;

            $book->update([
                'judul_buku' => $request->judul_buku,
                'jumlah_buku' => $request->jumlah_buku,
                'id_kategori' => $request->id_kategori
            ]);

            return redirect()->route('booksAdmin.index')->with('success', 'Buku berhasil Diubah!');

        } catch (\Exception $e) {
            return redirect()->route('booksAdmin.index')->with('error', 'Data Buku Gagal Diubah!');
        }
    }

    // Remove the specified resource from storage.
    public function destroy($id_buku) : RedirectResponse
    {
        $delBookByID = Book::findOrFail($id_buku);

        Storage::disk('public')->delete($delBookByID->barcode_buku);

        //delete product
        $delBookByID->delete();

        //redirect to index
        return redirect()->route('booksAdmin.index')->with(['success' => 'Data Buku Berhasil Dihapus!']);
    }
}
