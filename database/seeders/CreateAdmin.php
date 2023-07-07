<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class CreateAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
          'name' => 'Admin',
          'email' => 'admin@test.com',
          'password' => Hash::make('admin@test.com'),
          'is_admin' => User::$admin
        ];
        User::updateOrCreate(['email' => 'admin@test.com','is_admin' =>User::$admin ],$data);
    }
}
