<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminLogin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins'; // Nama tabel di database
    protected $primaryKey = 'id_admin'; // Primary key custom
    public $incrementing = false; // Karena ID bukan auto-increment
    protected $keyType = 'string'; // Tipe data ID (misal string: USER001)

    protected $fillable = [
        'id_admin', 'password', 'nama_admin' // pastikan kolom nama_user ada
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
