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
        DB::table('users')->delete();


        // Création d’un client
        $client = User::create([
            'name' => 'Geremie',
            'last_name' => 'Doe',
            'birthday' => '1990-01-01',
            'contact' => '1234567890',
            'email' => 'client@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'adresse' => '456 Client Avenue',
        ]);

        Client::create([
            'client_id' => $client->id,
            'genre' => 'Homme',
        ]);



        // Création d’un personnel
        $personnel1 = User::create([
            'name' => 'Koffi',
            'last_name' => 'Dante',
            'birthday' => '1990-01-01',
            'contact' => '1234567890',
            'email' => 'personnel@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'adresse' => '789 Personnel Road',
        ]);

        $personnel2 = User::create([
            'name' => 'Jean',
            'last_name' => 'Marque',
            'birthday' => '2000-10-01',
            'contact' => '1234567890',
            'email' => 'personnel2@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'adresse' => '789 Personnel Road',
        ]);

        Personnel::create([
            'personnel_id' => $personnel1->id,
            'poste' => 'blanchisseur',
            'pressing_id' => 1,
            'sexe' => "M",
            'date_embauche' => '12/03/2022',
        ]);

        Personnel::create([
            'personnel_id' => $personnel2->id,
            'poste' => 'detacheur',
            'pressing_id' => 2,
            'sexe' => "M",
            'date_embauche' => '12/03/2022',
        ]);

        // Création d’un gestionnaire
        $gestionnaire = User::create([
            'name' => 'Gregory',
            'last_name' => 'Smith',
            'birthday' => '1990-01-01',
            'contact' => '1234567890',
            'email' => 'gestionnaire@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'adresse' => '101 Gestionnaire Blvd',
        ]);

        Gestionnaire::create([
            'gestionnaire_id' => $gestionnaire->id
        ]);


        // Assignation des rôles

        $client->assignRole('client');
        $personnel1->assignRole('personnel');
        $personnel2->assignRole('personnel');
        $gestionnaire->assignRole('gestionnaire');
    }
}
