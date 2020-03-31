<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            'name' => 'Site Administrator',
            'username' => 'admin',
            'email' => 'email@example.com',
            'password' => bcrypt('12345'),
        ];
        User::create($admin);
    }
}