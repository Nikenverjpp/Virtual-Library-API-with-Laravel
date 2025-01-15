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
        $this->call(UserSeeder::class);
        $this->call(BookSeeder::class);
        //seeder for administrator user data and generating tokens for it
        // $admin = User::create([
        //     'name' => 'adminLibrary',
        //     'email' => 'adminLibrary@gmail.com',
        //     'password' => Hash::make('Admin.123'),
        //     'remember_token' => Str::random(10),
        //     'is_admin' => true,
        // ]);

        // $adminToken = $admin->createToken('test')->plainTextToken;
        // echo "Admin Token: " . $adminToken . PHP_EOL;

        // //seeder for data of 10 administrator users and generating tokens for them
        // $users = User::factory()->count(10)->create();
        // foreach($users as $user){
        //     $token = $user->createToken('test')->plainTextToken;
        // }

        //seeder to populate the database with fictitious book data
        //create 10 dummy records in the books table
        // Book::factory()->count(10)->create();
    }
}
