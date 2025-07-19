<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypePrestationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprime toutes les données existantes
        DB::table('type_prestations')->delete();

        // Définis les données à insérer
        $typePrestations = [
            ['intitule' => 'Nettoyage à sec'],
            ['intitule' => 'Repassage'],
            ['intitule' => 'Lavage'],
            ['intitule' => 'Détachage'],
            ['intitule' => 'Teinture'],
        ];

        // Ajoute les timestamps automatiquement
        foreach ($typePrestations as &$prestation) {
            $prestation['created_at'] = now();
            $prestation['updated_at'] = now();
        }

        // Insère les données dans la table
        DB::table('type_prestations')->insert($typePrestations);
    }
}