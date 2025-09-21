<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'employee_id' => '500000',
            'name' => 'SUPER ADMIN TLP',
            'email' => 'admin-tlp@testing.com',
            'password' => Hash::make('TLP001'),
            'role' => 'Admin',
            'department' => 'IT',
            'designation' => 'Operation Officer',
            'status' => 1,
        ]);
    }
}
