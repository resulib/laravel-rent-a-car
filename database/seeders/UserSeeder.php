<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'u@u'],
            [
                'name' => 'User',
                'email' => 'u@u',
                'password' => Hash::make('u'),
                'is_admin' => false,
            ]
        );
    }
}
