<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanDetail extends Model
{
    use HasFactory;

    protected $table = 'loan_details';
    protected $primaryKey = 'id_detail_peminjaman';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_detail_peminjaman',
        'id_peminjaman',
        'id_buku',
        'jumlah',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function book()
    {
        return $this->belongsTo(\App\Models\Book::class, 'id_buku', 'id_buku');
    }
}
