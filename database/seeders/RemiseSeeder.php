<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RemiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Exemple de données pour la table remises
        DB::table('remises')->insert([
            [
                'type_remise' => 'pourcentage',
                'valeur' => 10.00,
                'description' => 'Remise de 10% sur la commande',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type_remise' => 'fixe',
                'valeur' => 500.00,
                'description' => 'Remise de 500 FCFA sur la commande',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type_remise' => 'pourcentage',
                'valeur' => 5.00,
                'description' => 'Remise de 5% pour les commandes supérieures à 1000 FCFA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type_remise' => 'fixe',
                'valeur' => 200.00,
                'description' => 'Remise de 200 FCFA pour les commandes de plus de 5 articles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
