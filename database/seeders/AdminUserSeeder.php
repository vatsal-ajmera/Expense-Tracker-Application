<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'user_type' => User::USER_TYPE_SUPER_ADMIN,
            'name' => 'Super Admin',
            'email' => 'admin@grr.la',
            'password' => Hash::make('123456789')
        ]);
    }
}
