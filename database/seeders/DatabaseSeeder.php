<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\{Book, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Generate 7 random books using the factory
        $this->call(UserSeeder::class);
        $this->call(BookSeeder::class);
    }
}
