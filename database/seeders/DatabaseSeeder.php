<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama agar tidak duplikat
        User::truncate();

        // Buat admin baru dengan Hash::make resmi dari Laravel
        User::create([
            'name' => 'Admin Desa',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
    }
}