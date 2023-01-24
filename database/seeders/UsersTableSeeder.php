<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id'    => 1,
            'name'    => 'SUPER ADMIN',
            'email'    => 'superadmin@gmail.com',
            'username'    => 'superadmin@gmail.com',
            'no_telp'    => '000000000000',
            'role_id'    => 1,
            'password'    => Hash::make(12345678),
        ]);
    }
}
