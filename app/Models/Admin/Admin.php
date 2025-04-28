<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory; 

    protected $table = 'admins'; // Sesuai dengan nama tabel di migration

    protected $primaryKey = 'id_admin'; // Set primary key ke id_kategori
    public $incrementing = false; // Karena bukan auto-increment (string)
    protected $keyType = 'string'; // Karena id_kategori bertipe string

    protected $fillable = [
        'id_admin',
        'password',
        'nama_admin',
        'role',
    ];
}
