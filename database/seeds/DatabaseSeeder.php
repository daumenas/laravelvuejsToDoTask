<?php

use Illuminate\Database\Seeder;
use App\User;
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
        User::create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin'),
            'role' => 2
        ]);
        User::create([
            'name' => 'user',
            'email' => 'user@test.com',
            'password' => Hash::make('secret'),
            'role' => 1
        ]);
    }
}
