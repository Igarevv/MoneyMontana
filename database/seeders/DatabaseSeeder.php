<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Database\Seeders\AuthDatabaseSeeder;
use Modules\ExpenseAccount\Database\Seeders\ExpenseAccountDatabaseSeeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AuthDatabaseSeeder::class,
            ExpenseAccountDatabaseSeeder::class,
        ]);
    }
}
