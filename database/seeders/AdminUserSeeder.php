<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create admin account
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL')],
            [
                'name' => 'Admin',
                'password' => Hash::make(env('ADMIN_PASSWORD')),
                'is_admin' => true,
            ]
        );
        
        // Create user account
        User::updateOrCreate(
            ['email' => env('GENERIC_USER_EMAIL')],
            [
                'name' => 'Admin',
                'password' => Hash::make(env('GENERIC_USER_PASSWORD')),
                'is_admin' => false,
            ]
        );

        // Using factory to generate other random users
        HostedImage::factory(25)->create();
    }
}