<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory; 

    protected $table = 'books'; // Sesuai dengan nama tabel di migration

    protected $primaryKey = 'id_buku'; // Set primary key ke id_kategori
    public $incrementing = false; // Karena bukan auto-increment (string)
    protected $keyType = 'string'; // Karena id_kategori bertipe string

    protected $fillable = [
        'id_buku',
        'judul_buku',
        'jumlah_buku',
        'id_kategori',
        'barcode_buku'	
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }
}
