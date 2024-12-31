<?php

namespace Database\Seeders;

use App\Lib\UserRole;
use App\Lib\UserType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin =
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'type' => UserType::STAFF,
                'user_role' => UserRole::ADMIN_ROLE,
            ];

        User::updateOrCreate(
            $admin,$admin
        );
    }
}
