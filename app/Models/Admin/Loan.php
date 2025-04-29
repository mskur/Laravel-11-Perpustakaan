<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'loans';
    protected $primaryKey = 'id_peminjaman';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_peminjaman',
        'id_user',
        'id_admin',
        'tanggal_pinjam',
        'tanggal_kembali'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }

    public function details()
    {
        return $this->hasMany(LoanDetail::class, 'id_peminjaman');
    }

    public function return()
    {
        return $this->hasOne(ReturnLoan::class, 'id_peminjaman', 'id_peminjaman');
    }
}
