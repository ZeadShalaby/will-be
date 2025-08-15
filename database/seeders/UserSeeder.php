<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@volt.com',
            'password' => Hash::make('wellbe1234'),
        ]);

        DB::table("users")->insert([
            'first_name' => 'user',
            'last_name' => 'only',
            'email' => 'user@volt.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
