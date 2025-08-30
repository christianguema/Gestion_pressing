<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VetementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprime les anciennes données
        DB::table('vetements')->delete();

        // Récupère tous les categorie_id disponibles
        $categorieIds = DB::table('categories')->pluck('categorie_id');

        if ($categorieIds->isEmpty()) {
            $this->command->warn('Aucune catégorie trouvée. Impossible d\'assigner une catégorie.');
            return;
        }

        // Exemples de types de vêtements
        $types = [
            'Chemise', 'Pantalon', 'Manteau', 'Robe', 'Jupe', 'Veste', 'T-shirt', 'Pull', 'Chandail', 'Costume','sous-vetement','Rideaux','Torchons'
        ];

        // Génère 20 vêtements aléatoires
        $vetements = [];

        for ($i = 1; $i <= 20; $i++) {
            $vetements[] = [
                'vetement_id' => $i,
                'type' => $types[array_rand($types)], // Choix aléatoire parmi les types
                'prix_unitaire' => round(rand(100, 1000)), // Ex : 45.99
                'categorie_id' => $categorieIds->random(), // Attribution aléatoire
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insertion dans la base
        DB::table('vetements')->insert($vetements);
    }
}
