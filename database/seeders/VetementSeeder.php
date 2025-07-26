<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $categories = DB::table('categories')->get(['categorie_id', 'intitule']);

        if ($categories->isEmpty()) {
            $this->command->warn('Aucune catégorie trouvée. Impossible d\'assigner une catégorie.');
            return;
        }

        // Liste des types de vêtements avec leurs plages de prix
        $types = [
            // Vêtements Homme
            [
                'type' => 'Chemise simple',
                'prix_min' => 500,
                'prix_max' => 500,
                'categorie' => 'Vêtements Hommes',
                
            ],
            [
                'type' => 'Pantalon',
                'prix_min' => 400,
                'prix_max' => 400,
                'categorie' => 'Vêtements Hommes',
                
            ],
            [
                'type' => 'Tricot',
                'prix_min' => 600,
                'prix_max' => 800,
                'categorie' => 'Vêtements Hommes',
                
            ],
            [
                'type' => 'Manteau',
                'prix_min' => 1500,
                'prix_max' => 1500,
                'categorie' => 'Vêtements Hommes',
                
            ],
            [
                'type' => 'Robe traditionnelle',
                'prix_min' => 1000,
                'prix_max' => 1000,
                'categorie' => 'Vêtements Femmes',
                
            ],
            [
                'type' => 'Complet traditionnel',
                'prix_min' => 2000,
                'prix_max' => 2500,
                'categorie' => 'Vêtements Hommes',
                
            ],
            [
                'type' => 'Chaussures',
                'prix_min' => 800,
                'prix_max' => 1000,
                'categorie' => 'Vêtements Hommes',
                
            ],
            // Ajoute ici les autres types de vêtements selon le tableau
        ];

        // Génère les vêtements
        $vetements = [];

        foreach ($types as $type) {
            // Trouve la catégorie correspondante
            $categorie = $categories->firstWhere('intitule', $type['categorie']);
            if (!$categorie) {
                $this->command->warn("Catégorie '{$type['categorie']}' non trouvée pour le type '{$type['type']}'.");
                continue;
            }

            // Génère un prix aléatoire dans la plage donnée
            $prix_unitaire = round(rand($type['prix_min'], $type['prix_max']) + rand(0, 99) / 100, 2);

            // Ajoute le vêtement
            $vetements[] = [
                'type' => $type['type'],
                'prix_unitaire' => $prix_unitaire,
                'categorie_id' => $categorie->categorie_id,
                
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insertion dans la base
        DB::table('vetements')->insert($vetements);
    }
}

// namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;

// class VetementSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         // Supprime les anciennes données
//         DB::table('vetements')->delete();

//         // Récupère tous les categorie_id disponibles
//         $categorieIds = DB::table('categories')->pluck('categorie_id');

//         if ($categorieIds->isEmpty()) {
//             $this->command->warn('Aucune catégorie trouvée. Impossible d\'assigner une catégorie.');
//             return;
//         }

//         // Exemples de types de vêtements
//         $types = [
//             'Chemise simple', 'Pantalon','Tricot', 'Manteau', 'Robe', 'Jupe', 'Veste', 'T-shirt', 'Pull', 'Chandail', 'Costume','Costume 3 pièces','Jean'
//         ];

//         // Génère 20 vêtements aléatoires
//         $vetements = [];

//         for ($i = 1; $i <= 20; $i++) {
//             $vetements[] = [
//                 'vetement_id' => $i,
//                 'type' => $types[array_rand($types)], // Choix aléatoire parmi les types
//                 'prix_unitaire' => round(rand(10, 200) + rand(0, 99) / 100, 2), // Ex : 45.99
//                 'categorie_id' => $categorieIds->random(), // Attribution aléatoire
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ];
//         }

//         // Insertion dans la base
//         DB::table('vetements')->insert($vetements);
//     }
// }