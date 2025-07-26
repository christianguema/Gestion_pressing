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
            ['categorie_id' => 1, 'intitule' => 'Vêtements Hommes'],
            ['categorie_id' => 2, 'intitule' => 'Vêtements Femmes'],
            ['categorie_id' => 3, 'intitule' => 'Meubles'],
            ['categorie_id' => 4, 'intitule' => 'Decorations'],
            ['categorie_id' => 5, 'intitule' => 'Autres'],
        ];

        DB::table('categories')->insert($categories);
    }
}
