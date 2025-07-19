<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PersonnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprimer les anciennes données
        DB::table('personnels')->delete();

        // Récupérer le rôle 'personnel'
        $role = Role::where('name', 'personnel')->first();

        if (!$role) {
            $this->command->warn('Le rôle "personnel" n\'existe pas. Veuillez le créer d\'abord.');
            return;
        }

        // Récupérer les IDs des utilisateurs avec le rôle 'personnel'
        $personnelUserIds = $role->users()->pluck('id');

        if ($personnelUserIds->isEmpty()) {
            $this->command->warn('Aucun utilisateur trouvé avec le rôle "personnel".');
            return;
        }

        // Récupérer tous les pressing_ids disponibles
        $pressingIds = DB::table('pressings')->pluck('pressing_id');

        if ($pressingIds->isEmpty()) {
            $this->command->warn('Aucun pressing trouvé. Impossible d\'assigner un pressing.');
            return;
        }

        // Générer les données à insérer
        $personnels = [];

        foreach ($personnelUserIds as $userId) {
            $personnels[] = [
                'personnel_id' => $userId, // personnel_id = user.id
                'poste' => $this->randomPoste(),
                'date_embauche' => now()->subMonths(rand(6, 48))->toDateString(),
                'pressing_id' => $pressingIds->random(), // assignation aléatoire
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insertion dans la base
        DB::table('personnels')->insert($personnels);
    }

    /**
     * Retourne un poste aléatoire parmi une liste prédéfinie
     */
    private function randomPoste(): string
    {
        $postes = [
            'Technicien Nettoyage',
            'Repassage',
            'Responsable de Pressing',
            'Agent de Réception',
            'Chef d\'équipe',
        ];

        return $postes[array_rand($postes)];
    }
}