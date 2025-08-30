<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommandeVetementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprime toutes les données existantes
        //DB::table('commande_vetement')->delete();

        // Récupère des IDs existants
        $commandeIds = DB::table('commandes')->pluck('commande_id');
        $vetementIds = DB::table('vetements')->pluck('vetement_id');

        if ($commandeIds->isEmpty() || $vetementIds->isEmpty()) {
            $this->command->warn('Aucune commande ou vêtement trouvé. Impossible de générer les données.');
            return;
        }

        // Génère des données de test
        $commandeVetements = [];

        // Exemple : 10 lignes de test
        for ($i = 1; $i <= 10; $i++) {
            $commandeVetements[] = [
                'commande_vetement_id' => $i,
                'commande_id' => $commandeIds->random(),
                'vetement_id' => $vetementIds->random(),
                'quantite' => rand(1, 5),
                'poids' => round(rand(0, 20) + rand(1, 99) / 100, 2), // Ex : 2.5 kg
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insertion des données
        DB::table('commande_vetement')->insert($commandeVetements);
    }
}
