<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class GestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprime les anciennes données
        //DB::table('gestionnaires')->delete();

        // Récupère le rôle 'gestionnaire'
        $role = Role::where('name', 'gestionnaire')->first();

        if (!$role) {
            $this->command->warn('Le rôle "gestionnaire" n\'existe pas. Veuillez le créer d\'abord.');
            return;
        }

        // Récupère les IDs des utilisateurs avec le rôle 'gestionnaire'
        $gestionnaireUserIds = $role->users()->pluck('id');

        if ($gestionnaireUserIds->isEmpty()) {
            $this->command->warn('Aucun utilisateur trouvé avec le rôle "gestionnaire".');
            return;
        }

        // Génère les données à insérer
        $gestionnaires = [];

        foreach ($gestionnaireUserIds as $userId) {
            $gestionnaires[] = [
                'gestionnaire_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insère les données
        DB::table('gestionnaires')->insert($gestionnaires);
    }
}
