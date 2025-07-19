<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PressingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pressings')->delete();

        $pressings = [
            [
                'pressing_id' => 1,
                'nom' => 'Pressing du Centre',
                'adresse' => '10 Rue de Paris, Paris',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pressing_id' => 2,
                'nom' => 'Nettoyage Express',
                'adresse' => '5 Avenue des Champs-Élysées, Paris',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pressing_id' => 3,
                'nom' => 'Pressing de la Gare',
                'adresse' => '15 Rue de la Gare, Lyon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pressings')->insert($pressings);
    }
}