<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::createOrFirst(
            [
                'email' => 'admin@admin.com',
            ],
            [
                'name' => 'Admin',
                'is_admin' => 1,
                'password' => Hash::make('password'),
            ]
        );

        // Create customer
        User::factory()->count(10)->create();
    }
}
