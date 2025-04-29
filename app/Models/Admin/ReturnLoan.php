<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnLoan extends Model
{
    protected $table = 'returns';

    protected $primaryKey = 'id_pengembalian';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pengembalian', 'id_peminjaman', 'tanggal_pengembalian', 'denda',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'id_peminjaman');
    }

    public function details()
    {
        return $this->hasMany(ReturnDetail::class, 'id_pengembalian');
    }
}

