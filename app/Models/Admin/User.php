<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory; 

    protected $table = 'users'; // Sesuai dengan nama tabel di migration

    protected $primaryKey = 'id_user'; // Set primary key ke id_kategori
    public $incrementing = false; // Karena bukan auto-increment (string)
    protected $keyType = 'string'; // Karena id_kategori bertipe string

    protected $fillable = [
        'id_user',
        'foto_user',
        'nama_user',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'password',
        'role',
        'barcode_user'
    ];
}
