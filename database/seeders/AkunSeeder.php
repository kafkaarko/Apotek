<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'kasirApotek',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('admin'),  // Menggunakan Hash::make untuk hashing
        //     'role' => 'kasir',
        // ]);        
        User::create([
            'name' => 'YangMulia',
            'email' => 'tet@gmail.com',
            'password' => Hash::make('admin'),  // Menggunakan Hash::make untuk hashing
            'role' => asset('images/akun/default.jpg')
        ]);        
    }
}
