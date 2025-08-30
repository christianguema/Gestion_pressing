<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DB::table('clients')->delete();

        // Récupérer le rôle "client"
        //$role = Role::findByName('client');
        $role = Role::where('name', 'client')->first();

        if ($role) {
            // Récupérer tous les utilisateurs avec le rôle "client"
            $clientUserIds = $role->users()->pluck('id');

            $clients = [];

            foreach ($clientUserIds as $userId) {
                $clients[] = [
                    'client_id' => $userId,
                    'telephone' => '0' . rand(1, 9) . ' ' . rand(10, 99) . ' ' . rand(10, 99) . ' ' . rand(10, 99) . ' ' . rand(10, 99),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('clients')->insert($clients);
        } else {
            // Si le rôle "client" n'existe pas
            $this->command->warn('Le rôle "client" n\'existe pas. Assurez-vous de l\'avoir créé.');
        }
    }
}
