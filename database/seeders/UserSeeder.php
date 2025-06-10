<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'fname' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
                'created_at' => now(),
            ],
            [
                'fname' => 'Manager',
                'username' => 'manager',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('manager'),
                'email_verified_at' => now(),
                'created_at' => now(),
            ],
            [
                'fname' => 'Editor',
                'username' => 'editor',
                'email' => 'editor@gmail.com',
                'password' => Hash::make('editor'),
                'email_verified_at' => now(),
                'created_at' => now(),
            ],
            [
                'fname' => 'Customer',
                'username' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('user'),
                'email_verified_at' => now(),
                'created_at' => now(),
            ],
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $user = DB::table('users');
        $user->truncate();
        $user->insert($users);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
