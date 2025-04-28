<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->insert([
            'id_admin' => 'ADMIN0001',
            'nama_admin' => 'Admin 1',
            'role' => 'admin',
            'password' => Hash::make('123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Tambahkan data admin lainnya
        DB::table('admins')->insert([
            'id_admin' => 'ADMIN0002',
            'nama_admin' => 'Admin 2',
            'role' => 'superadmin',
            'password' => Hash::make('123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

