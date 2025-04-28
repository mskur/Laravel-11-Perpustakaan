<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use HasFactory;

    protected $table = 'users'; // Nama tabel

    protected $primaryKey = 'id_user'; // Primary key
    public $incrementing = false; // Karena id_user bukan auto-increment
    protected $keyType = 'string'; // id_user bertipe string

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
