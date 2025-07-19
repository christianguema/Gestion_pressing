<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprime les anciennes données
        DB::table('paiements')->delete();

        // Récupère les commande_id existants
        $commandeIds = DB::table('commandes')->pluck('commande_id');

        if ($commandeIds->isEmpty()) {
            $this->command->warn('Aucune commande trouvée. Impossible de générer les paiements.');
            return;
        }

        // Génère des données de test
        $paiements = [];

        foreach (range(1, 10) as $i) {
            $paiements[] = [
                'paiement_id' => $i,
                'commande_id' => $commandeIds->random(),
                'montant' => round(rand(20, 500) + rand(0, 99) / 100, 2), // Ex : 123.45
                'mode_paiement' => ['Carte Bancaire', 'Espèces', 'Virement', 'PayPal'][rand(0, 3)],
                'statut' => ['Réussi', 'Échoué', 'En attente'][rand(0, 2)],
                'date_paiement' => now()->subDays(rand(1, 30))->toDateString(),
                'reference_transaction' => 'TXN' . rand(100000, 999999),
                'fature' => 'facture_' . $i . '.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insertion dans la base
        DB::table('paiements')->insert($paiements);
    }
}