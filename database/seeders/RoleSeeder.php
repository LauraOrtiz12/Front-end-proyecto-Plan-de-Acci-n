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
            [[
                'rol' => 'admin',
                'description' => 'Administrador',
            ],
            [
                'rol' => 'Direccion',
                'description' => 'Director(a) del área de planeación',
            ],
            [
                'rol' => 'Asesor',
                'description' => 'Asesor de planeacion',
            ],
            [
                'rol' => 'Director(a)',
                'description' => 'Director(a) regional',
            ],
            [
                'rol' => 'Subdirector(a)',
                'description' => 'Subdirector(a) de centro',
            ]]
        );
    }
}
