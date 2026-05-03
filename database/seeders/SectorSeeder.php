<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectors = [
            ['name' => 'Construction', 'slug' => 'construction', 'description' => 'Building and construction materials.'],
            ['name' => 'Energy', 'slug' => 'energy', 'description' => 'Renewable and green energy solutions.'],
            ['name' => 'Healthcare', 'slug' => 'healthcare', 'description' => 'Medical technology and healthcare services.'],
            ['name' => 'Technology', 'slug' => 'technology', 'description' => 'Software and hardware innovations.'],
        ];

        foreach ($sectors as $sector) {
            \App\Models\Sector::create($sector);
        }
    }
}
