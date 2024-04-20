<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert(
            [
                'rol' => 'admin',
                'description' => 'Administrador',
            ],
            [
                'rol' => 'direccion',
                'description' => 'Director(a) del área de planeación',
            ],
            [
                'rol' => 'asesor',
                'description' => 'Asesor de planeacion',
            ],
            [
                'rol' => 'director',
                'description' => 'Director regional',
            ],
            [
                'rol' => 'subdirector',
                'description' => 'subdirector de centro',
            ]
        );
    }
}
