<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class ReturnDetail extends Model
{
    protected $table = 'return_details';

    protected $primaryKey = 'id_detail_pengembalian';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_detail_pengembalian', 'id_pengembalian', 'id_buku', 'jumlah',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'id_buku');
    }
}
