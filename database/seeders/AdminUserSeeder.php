<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL')],
            [
                'name' => 'Admin',
                'password' => Hash::make(env('ADMIN_PASSWORD')),
                'is_admin' => true,
            ]
        );
    }
}
