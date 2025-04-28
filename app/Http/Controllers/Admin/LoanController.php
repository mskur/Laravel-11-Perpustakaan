<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Loan;
use App\Models\Admin\LoanDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Auth\AdminLogin;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with('user', 'admin', 'details.book')->latest();

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;

            $query->where(function($q) use ($keyword) {
                $q->where('id_peminjaman', 'like', '%' . $keyword . '%')
                  ->orWhereHas('user', function ($qUser) use ($keyword) {
                      $qUser->where('nama_user', 'like', '%' . $keyword . '%');
                  });
            });
        }

        $loans = $query->paginate(4); // <- Ubah ke 10 kalau sudah
        $loans->appends(['search' => $request->search]);

        return view('admins.loans.viewLoans', compact('loans'));
    }

    public function create()
    {
        $books = Book::all();
        return view('admins.loans.createLoan', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'id_admin' => 'required|exists:admins,id_admin',
            'id_user' => 'required|exists:users,id_user',
            'books' => 'required|array|min:1',
            'books.*.id_buku' => 'required|exists:books,id_buku',
            'books.*.jumlah' => 'required|integer|min:1',
        ]);

        $lastLoan = Loan::orderBy('id_peminjaman', 'desc')->first();
        $newLoanCode = 'LOAN00000001'; // Default
        if ($lastLoan) {
            $number = (int) substr($lastLoan->id_peminjaman, 4) + 1;
            $newLoanCode = 'LOAN' . str_pad($number, 8, '0', STR_PAD_LEFT);
        }

        $lastDetail = LoanDetail::orderBy('id_detail_peminjaman', 'desc')->first();
        $lastDetailNumber = 1;
        if ($lastDetail) {
            $lastDetailNumber = (int) substr($lastDetail->id_detail_peminjaman, 6) + 1;
        }

        DB::beginTransaction();
        try {
            // Insert ke loans
            $loan = Loan::create([
                'id_peminjaman' => $newLoanCode,
                'id_user' => $request->id_user,
                'id_admin' => $request->id_admin,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
            ]);

            foreach ($request->books as $bookRequest) {
                $book = Book::findOrFail($bookRequest['id_buku']);

                if ($book->jumlah_buku < $bookRequest['jumlah']) {
                    throw new \Exception('Stok buku "' . $book->judul_buku . '" tidak cukup.');
                }

                $book->decrement('jumlah_buku', $bookRequest['jumlah']);

                $newDetailCode = 'DETAIL' . str_pad($lastDetailNumber, 9, '0', STR_PAD_LEFT);

                LoanDetail::create([
                    'id_detail_peminjaman' => $newDetailCode,
                    'id_peminjaman' => $loan->id_peminjaman,
                    'id_buku' => $bookRequest['id_buku'],
                    'jumlah' => $bookRequest['jumlah'],
                ]);

                $lastDetailNumber++; // Tambah counter untuk ID berikutnya
            }

            DB::commit();
            return redirect()->route('loansAdmin.index')->with('success', 'Peminjaman berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan peminjaman: ' . $e->getMessage());
        }
    }

}
