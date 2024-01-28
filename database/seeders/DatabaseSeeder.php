<?php

namespace Database\Seeders;

use Database\Seeders\Demo\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ConfigureMeilisearch::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
    }
}
