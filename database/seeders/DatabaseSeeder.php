<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // JANGAN pakai User::factory() — kita tidak punya UserFactory
        // Cukup seed admin saja
        $this->call([
            AdminSeeder::class,
        ]);
    }
}