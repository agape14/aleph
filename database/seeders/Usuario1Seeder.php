<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Usuario1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
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
            'email' => 'notificaciones@colegioaleph.edu.pe',
            'password'=>bcrypt('Aleph2025'),
            'role'=>'1' //1 for Admin
        ]);
    }
}
