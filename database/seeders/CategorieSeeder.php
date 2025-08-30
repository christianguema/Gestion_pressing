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
            ['categorie_id' => 1, 'intitule' => 'Hommes'],
            ['categorie_id' => 2, 'intitule' => 'Femmes'],
            ['categorie_id' => 3, 'intitule' => 'Enfants'],
            ['categorie_id' => 4, 'intitule' => 'Bébés'],
            ['categorie_id' => 5, 'intitule' => 'Meubles'],
        ];

        DB::table('categories')->insert($categories);
    }
}
