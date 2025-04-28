<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'id_user' => 'USER0001',
            'foto_user' => 'default.jpg',
            'nama_user' => 'Imam Maskuri',
            'tanggal_lahir' => '1998-05-10',
            'alamat' => 'Gresik',
            'no_hp' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'barcode_user' => '1234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

