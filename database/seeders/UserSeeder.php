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
            'role_id' => 1,
            'code' => 'admin001',
            'name' => 'Wilson Ramirez Zuluaga',
            'email' => 'wramirez@sena.edu.co',
            'phone' => '123-456-',
            'password' => bcrypt('123')
        ]);
    }
}
