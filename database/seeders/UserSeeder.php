<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin user
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin.123'),
            'is_admin' => true,
        ]);

        // Create an access personal token for the admin user
        PersonalAccessToken::create([ 
            'tokenable_id' => $admin->id, 
            'tokenable_type' => 'App\Models\User', 
            'name' => 'auth_token', 
            'token' => hash('sha256', 'Qwelr4GaAW8UccQ7DfsHe0b65RdkNBQdJlPynGwi'), 
            'abilities' => ['*'],
        ]);

        // Create a regular user
        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user.123'),
            'is_admin' => false,
        ]);

        // Create an access personal token for the regular user
        PersonalAccessToken::create([ 
            'tokenable_id' => $user->id, 
            'tokenable_type' => 'App\Models\User', 
            'name' => 'auth_token', 
            'token' => hash('sha256', 'FlSgxorFOqyngyl8hT4sKlzeS0IHIsWNUjiKrCHo'), 
            'abilities' => ['*'],
        ]);
    }
}
