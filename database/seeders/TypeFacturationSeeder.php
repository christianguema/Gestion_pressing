<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeFacturationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprime toutes les données existantes
        DB::table('type_facturations')->delete();

        // Définis les données à insérer
        $typeFacturations = [
            ['libelle' => 'Heure'],
            ['libelle' => 'Pièce'],
            ['libelle' => 'Forfait'],
            ['libelle' => 'Journée'],
            ['libelle' => 'Mois'],
        ];

        // Ajoute les timestamps automatiquement
        foreach ($typeFacturations as &$facturation) {
            $facturation['created_at'] = now();
            $facturation['updated_at'] = now();
        }

        // Insère les données dans la table
        DB::table('type_facturations')->insert($typeFacturations);
    }
}