<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Gestionnaire;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clients')->delete();
        DB::table('personnels')->delete();
        DB::table('gestionnaires')->delete();
        DB::table('users')->delete();


        // Création d’un client
        $client = User::create([
            'name' => 'Client User',
            'email' => 'client@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'adresse' => '456 Client Avenue',
        ]);

        Client::create([
            'client_id' => $client->id
        ]);

          // Création d’un personnel
        $personnel = User::create([
            'name' => 'Personnel User',
            'email' => 'personnel@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'adresse' => '789 Personnel Road',
        ]);

        Personnel::create([
            'user_id' => $personnel->id,
            'poste' => 'blanchisseur',
            'date_embauche' => '2022-03-12',
            'profilImage' => null,
            

        ]);

        // Création d’un gestionnaire
        $gestionnaire = User::create([
            'name' => 'Gestionnaire User',
            'email' => 'gestionnaire@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'adresse' => '101 Gestionnaire Blvd',
        ]);

        Gestionnaire::create([
            'gestionnaire_id' => $gestionnaire->id
        ]);


         // Assignation des rôles

        // $client->assignRole('client');
        // $personnel->assignRole('personnel');
        // $gestionnaire->assignRole('gestionnaire');

        $client->syncRoles('client');           // ✅ Remplace tous les rôles par 'client'
        $personnel->syncRoles('personnel');     // ✅ Meilleur que assignRole()
        $gestionnaire->syncRoles('gestionnaire');
    }
}
