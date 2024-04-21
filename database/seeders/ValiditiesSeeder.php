<?php

namespace Database\Seeders;

use App\Models\Validity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ValiditiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Validity::insert([
            [
                'validity' => '2023'
            ],
            [
                'validity' => '2024'
            ],
            [
                'validity' => '2025'
            ],
            [
                'validity' => '2026'
            ]
        ]);
    }
}
