<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ReturnLoan;
use App\Models\Admin\ReturnDetail;
use App\Models\Admin\Loan;
use App\Models\Admin\LoanDetail;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReturnController extends Controller
{
    public function index(Request $request)
    {
        $query = ReturnLoan::with('loan.user', 'details.book')->latest();

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('id_pengembalian', 'like', '%' . $keyword . '%')
                  ->orWhereHas('loan.user', function ($qUser) use ($keyword) {
                      $qUser->where('nama_user', 'like', '%' . $keyword . '%');
                  });
            });
        }

        $returns = $query->paginate(10);
        $returns->appends(['search' => $request->search]);

        return view('admins.returns.viewReturns', compact('returns'));
    }

    public function returnLoan($id)
    {
        try {
            $loan = Loan::with('details.book')->findOrFail($id);

            // Cek apakah sudah dikembalikan
            if (ReturnLoan::where('id_peminjaman', $loan->id_peminjaman)->exists()) {
                return redirect()->route('returnsAdmin.index')->with('error', 'Peminjaman sudah dikembalikan.');
            }

            $today = Carbon::today();
            $tanggalKembali = Carbon::parse($loan->tanggal_kembali);
            $dendaPerHari = 2000;
            $denda = 0;

            if ($today->gt($tanggalKembali)) {
                $selisihHari = $today->diffInDays($tanggalKembali);
                $denda = $selisihHari * $dendaPerHari;
            }

            // Generate id_pengembalian baru
            $lastReturn = ReturnLoan::orderBy('id_pengembalian', 'desc')->first();
            $lastReturnNumber = $lastReturn ? (int)substr($lastReturn->id_pengembalian, 3) : 0;
            $newReturnId = 'RET' . str_pad($lastReturnNumber + 1, 8, '0', STR_PAD_LEFT);

            DB::beginTransaction();

            // Simpan ke tabel returns
            $return = ReturnLoan::create([
                'id_pengembalian' => $newReturnId,
                'id_peminjaman' => $loan->id_peminjaman,
                'tanggal_pengembalian' => $today,
                'denda' => $denda,
            ]);

            foreach ($loan->details as $detail) {
                // Generate id_detail_pengembalian baru
                $lastDetail = ReturnDetail::orderBy('id_detail_pengembalian', 'desc')->first();
                $lastDetailNumber = $lastDetail ? (int)substr($lastDetail->id_detail_pengembalian, 4) : 0;
                $newDetailId = 'RTDT' . str_pad($lastDetailNumber + 1, 10, '0', STR_PAD_LEFT);

                ReturnDetail::create([
                    'id_detail_pengembalian' => $newDetailId,
                    'id_pengembalian' => $return->id_pengembalian,
                    'id_buku' => $detail->id_buku,
                    'jumlah' => $detail->jumlah,
                ]);

                // Update stok buku
                $book = Book::find($detail->id_buku);
                if ($book) {
                    $book->jumlah_buku += $detail->jumlah;
                    $book->save();
                }
            }

            DB::commit();
            return redirect()->route('returnsAdmin.index')->with('success', 'Peminjaman berhasil dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengembalikan peminjaman: ' . $e->getMessage());
        }
    }
}
