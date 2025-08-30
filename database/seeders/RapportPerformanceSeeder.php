<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RapportPerformanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DB::table('rapports_performance')->delete();

        // Récupère les IDs des gestionnaires
        $gestionnaireIds = DB::table('gestionnaires')->pluck('gestionnaire_id');

        if ($gestionnaireIds->isEmpty()) {
            $this->command->warn('Aucun gestionnaire trouvé. Impossible de générer les rapports.');
            return;
        }

        $rapports = [];

        foreach (range(1, 5) as $i) {
            $rapports[] = [
                'rapport_performance_id' => $i,
                'gestionnaire_id' => $gestionnaireIds->random(),
                'periode' => now()->subMonths(rand(1, 12))->format('Y-m'),
                'revenus' => round(rand(1000, 10000) + rand(0, 99) / 100, 2),
                'nombre_commande' => rand(10, 100),
                'satisfaction_client' => ['Très satisfaisant', 'Satisfaisant', 'Moyen', 'Insatisfaisant'][rand(0, 3)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('rapports_performance')->insert($rapports);
    }
}
