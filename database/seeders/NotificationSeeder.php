<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DB::table('notifications')->delete();

        // Récupère les IDs des utilisateurs
        $userIds = DB::table('users')->pluck('id');

        if ($userIds->isEmpty()) {
            $this->command->warn('Aucun utilisateur trouvé. Impossible de générer les notifications.');
            return;
        }

        $notifications = [];

        foreach (range(1, 10) as $i) {
            $notifications[] = [
                'notification_id' => $i,
                'user_id' => $userIds->random(),
                'contenu' => 'Vous avez une nouvelle commande en attente.',
                'lu' => rand(0, 1),
                'date_envoi' => now()->subDays(rand(1, 30))->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('notifications')->insert($notifications);
    }
}
