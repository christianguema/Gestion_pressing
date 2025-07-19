<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->delete();

        $categories = [
            ['categorie_id' => 1, 'intitule' => 'Chemises'],
            ['categorie_id' => 2, 'intitule' => 'Pantalons'],
            ['categorie_id' => 3, 'intitule' => 'Manteaux'],
            ['categorie_id' => 4, 'intitule' => 'Robes'],
            ['categorie_id' => 5, 'intitule' => 'Vestes'],
        ];

        DB::table('categories')->insert($categories);
    }
}
