<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id'=>1,
            'name' => 'Admin',
            'email'=>'admin@admin.com',
            'password'=>bcrypt('password'),
            'role'=>'1' //1 for Admin
        ]);
        User::create([
            'id'=>2,
            'name' => 'User',
            'email'=>'user@user.com',
            'password'=>bcrypt('password'),
            'role'=>'0' //0 for User
        ]);

        User::create([
            'id'=>3,
            'name' => 'Carlos Soraluz',
            'email' => 'carlos.soraluz@gmail.com',
            'password'=>bcrypt('password'),
            'role'=>'1' //1 for Admin
        ]);

        User::create([
            'id'=>4,
            'name' => 'Gestor Aleph',
            'email' => 'gestor.aleph@gmail.com',
            'password'=>bcrypt('Aleph2025'),
            'role'=>'1' //1 for Admin
        ]);
    }
}
