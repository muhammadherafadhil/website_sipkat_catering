<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // updateOrCreate: kalau email sudah ada → update, kalau belum → insert
        User::updateOrCreate(
            ['email' => 'admin@sipkat.test'],        // kunci pencarian
            [
                'name'     => 'Administrator',
                'phone'    => '081234567890',
                'password' => Hash::make('password'),
                'role'     => User::ROLE_ADMIN,
            ]
        );

        $this->command->info('✅ Admin siap: admin@sipkat.test / password');
    }
}