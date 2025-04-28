<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory; 

    protected $table = 'categories'; // Sesuai dengan nama tabel di migration

    protected $primaryKey = 'id_kategori'; // Set primary key ke id_kategori
    public $incrementing = false; // Karena bukan auto-increment (string)
    protected $keyType = 'string'; // Karena id_kategori bertipe string

    protected $fillable = [
        'id_kategori',
        'kategori',
        'kode_rak',
    ];
}
